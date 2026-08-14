<?php

namespace App\Services;

use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Throwable;

class InstagramFeedService
{
    /**
     * Latest Instagram posts for the homepage carousel.
     *
     * @return Collection<int, array{id: string, image: string, permalink: string, caption: string, media_type: string}>
     */
    public function latestPosts(int $limit = 8): Collection
    {
        $token = trim((string) config('services.instagram.access_token'));
        $accountId = trim((string) config('services.instagram.business_account_id'));

        if ($token === '' || $accountId === '') {
            return collect();
        }

        $cacheKey = 'instagram.feed.'.$accountId.'.'.$limit;

        try {
            $cached = Cache::get($cacheKey);
            if ($cached instanceof Collection) {
                return $cached;
            }

            $posts = $this->fetchFromGraph($token, $accountId, $limit);

            if ($posts->isNotEmpty()) {
                Cache::put($cacheKey, $posts, now()->addHour());
            }

            return $posts;
        } catch (Throwable $e) {
            Log::warning('Instagram feed cache/fetch failed.', ['error' => $e->getMessage()]);

            return collect();
        }
    }

    /**
     * @return Collection<int, array{id: string, image: string, permalink: string, caption: string, media_type: string}>
     */
    private function fetchFromGraph(string $token, string $accountId, int $limit): Collection
    {
        $response = Http::timeout(8)
            ->acceptJson()
            ->get('https://graph.facebook.com/v21.0/'.$accountId.'/media', [
                'fields' => 'id,caption,media_type,media_url,thumbnail_url,permalink,timestamp',
                'limit' => $limit,
                'access_token' => $token,
            ]);

        if (! $response->successful()) {
            Log::warning('Instagram Graph API request failed.', [
                'status' => $response->status(),
                'body' => $response->json(),
            ]);

            return collect();
        }

        $items = $response->json('data') ?? [];

        return collect($items)
            ->map(function (array $item): ?array {
                $type = strtoupper((string) ($item['media_type'] ?? 'IMAGE'));
                $image = $type === 'IMAGE'
                    ? ($item['media_url'] ?? null)
                    : ($item['thumbnail_url'] ?? $item['media_url'] ?? null);

                if (! is_string($image) || $image === '') {
                    return null;
                }

                $permalink = $item['permalink'] ?? 'https://www.instagram.com/ksbhomes_/';
                $caption = trim((string) ($item['caption'] ?? ''));

                return [
                    'id' => (string) ($item['id'] ?? ''),
                    'image' => $image,
                    'permalink' => is_string($permalink) ? $permalink : 'https://www.instagram.com/ksbhomes_/',
                    'caption' => $caption !== '' ? $caption : 'KSB Luxury Homes on Instagram',
                    'media_type' => $type,
                ];
            })
            ->filter()
            ->values();
    }
}
