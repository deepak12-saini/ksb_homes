<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Throwable;

class InstagramThumbnailService
{
    /**
     * Fetch Instagram thumbnail, download it, and store permanently on local disk.
     * Returns a relative public-disk path such as "instagram-posts/abc.jpg".
     */
    public function storeLocalThumbnail(string $permalink, ?string $existingPath = null): ?string
    {
        $remoteUrl = $this->fetchThumbnailUrl($permalink);

        if (! $remoteUrl) {
            return null;
        }

        $localPath = $this->downloadToLocal($remoteUrl, $permalink);

        if (! $localPath) {
            return null;
        }

        if ($existingPath && $existingPath !== $localPath && $this->isLocalPath($existingPath)) {
            $this->deleteLocalFile($existingPath);
        }

        return $localPath;
    }

    /**
     * If value is a remote CDN URL, download and replace with a local path.
     * If already local and file exists, keep it. If local but missing, re-fetch.
     */
    public function ensureLocalThumbnail(string $permalink, ?string $currentValue): ?string
    {
        if ($currentValue && $this->isLocalPath($currentValue) && Storage::disk('public')->exists($currentValue)) {
            return $currentValue;
        }

        return $this->storeLocalThumbnail($permalink, $this->isLocalPath((string) $currentValue) ? $currentValue : null);
    }

    public function isLocalPath(?string $value): bool
    {
        if (! $value) {
            return false;
        }

        return ! str_starts_with($value, 'http://') && ! str_starts_with($value, 'https://');
    }

    public function deleteLocalFile(?string $path): void
    {
        if ($path && $this->isLocalPath($path) && Storage::disk('public')->exists($path)) {
            Storage::disk('public')->delete($path);
        }
    }

    public function fetchThumbnailUrl(string $permalink): ?string
    {
        $permalink = rtrim(trim($permalink), '/').'/';

        foreach ([
            fn () => $this->fetchFromGraphOembed($permalink),
            fn () => $this->fetchFromLegacyOembed($permalink),
            fn () => $this->fetchFromMediaRedirect($permalink),
            fn () => $this->fetchFromEmbedPage($permalink),
            fn () => $this->fetchFromOpenGraph($permalink),
        ] as $fetcher) {
            try {
                $url = $fetcher();

                if (is_string($url) && $url !== '') {
                    return $url;
                }
            } catch (Throwable $e) {
                Log::debug('Instagram thumbnail fetch attempt failed.', [
                    'permalink' => $permalink,
                    'error' => $e->getMessage(),
                ]);
            }
        }

        return null;
    }

    public function extractShortcode(string $permalink): ?string
    {
        if (preg_match('~instagram\.com/(?:p|reel|tv)/([\w-]+)~i', $permalink, $matches)) {
            return $matches[1];
        }

        return null;
    }

    private function downloadToLocal(string $remoteUrl, string $permalink): ?string
    {
        try {
            $response = Http::timeout(20)
                ->withHeaders($this->browserHeaders())
                ->withOptions(['allow_redirects' => true])
                ->get($remoteUrl);

            if (! $response->successful()) {
                return null;
            }

            $contentType = strtolower((string) $response->header('Content-Type'));
            $body = $response->body();

            if ($body === '' || strlen($body) < 100) {
                return null;
            }

            // Reject HTML login walls pretending to be images.
            if (str_contains($contentType, 'text/html') || str_starts_with(ltrim($body), '<')) {
                return null;
            }

            $extension = $this->extensionFromContentType($contentType)
                ?? $this->extensionFromUrl($remoteUrl)
                ?? 'jpg';

            $shortcode = $this->extractShortcode($permalink) ?: Str::random(10);
            $filename = $shortcode.'-'.Str::lower(Str::random(8)).'.'.$extension;
            $path = 'instagram-posts/'.$filename;

            Storage::disk('public')->put($path, $body);

            return $path;
        } catch (Throwable $e) {
            Log::warning('Instagram thumbnail download failed.', [
                'permalink' => $permalink,
                'remote' => $remoteUrl,
                'error' => $e->getMessage(),
            ]);

            return null;
        }
    }

    private function extensionFromContentType(string $contentType): ?string
    {
        $map = [
            'image/jpeg' => 'jpg',
            'image/jpg' => 'jpg',
            'image/png' => 'png',
            'image/webp' => 'webp',
            'image/gif' => 'gif',
        ];

        foreach ($map as $mime => $ext) {
            if (str_contains($contentType, $mime)) {
                return $ext;
            }
        }

        return null;
    }

    private function extensionFromUrl(string $url): ?string
    {
        $path = parse_url($url, PHP_URL_PATH);
        if (! is_string($path)) {
            return null;
        }

        $ext = strtolower(pathinfo($path, PATHINFO_EXTENSION));

        return in_array($ext, ['jpg', 'jpeg', 'png', 'webp', 'gif'], true)
            ? ($ext === 'jpeg' ? 'jpg' : $ext)
            : null;
    }

    private function fetchFromGraphOembed(string $permalink): ?string
    {
        $token = trim((string) config('services.instagram.access_token'));

        if ($token === '') {
            return null;
        }

        $response = Http::timeout(8)
            ->acceptJson()
            ->get('https://graph.facebook.com/v21.0/instagram_oembed', [
                'url' => $permalink,
                'access_token' => $token,
                'fields' => 'thumbnail_url',
            ]);

        if (! $response->successful()) {
            return null;
        }

        return $response->json('thumbnail_url');
    }

    private function fetchFromLegacyOembed(string $permalink): ?string
    {
        $response = Http::timeout(8)
            ->acceptJson()
            ->withHeaders($this->browserHeaders())
            ->get('https://www.instagram.com/api/v1/oembed/', [
                'url' => $permalink,
            ]);

        if (! $response->successful()) {
            return null;
        }

        return $response->json('thumbnail_url');
    }

    private function fetchFromMediaRedirect(string $permalink): ?string
    {
        $shortcode = $this->extractShortcode($permalink);

        if ($shortcode === null) {
            return null;
        }

        $type = 'p';
        if (preg_match('~instagram\.com/reel/~i', $permalink)) {
            $type = 'reel';
        } elseif (preg_match('~instagram\.com/tv/~i', $permalink)) {
            $type = 'tv';
        }

        $mediaUrl = "https://www.instagram.com/{$type}/{$shortcode}/media/?size=l";

        $response = Http::timeout(10)
            ->withOptions(['allow_redirects' => false])
            ->withHeaders($this->browserHeaders())
            ->get($mediaUrl);

        $location = $response->header('Location');

        if ($location && $this->looksLikeCdnImageUrl($location)) {
            return $location;
        }

        if ($response->successful() && str_starts_with((string) $response->header('Content-Type'), 'image/')) {
            return $mediaUrl;
        }

        return null;
    }

    private function fetchFromEmbedPage(string $permalink): ?string
    {
        $shortcode = $this->extractShortcode($permalink);

        if ($shortcode === null) {
            return null;
        }

        $embedUrl = preg_match('~instagram\.com/reel/~i', $permalink)
            ? "https://www.instagram.com/reel/{$shortcode}/embed/"
            : "https://www.instagram.com/p/{$shortcode}/embed/";

        $response = Http::timeout(10)
            ->withHeaders($this->browserHeaders())
            ->get($embedUrl);

        if (! $response->successful()) {
            return null;
        }

        return $this->extractOgImageFromHtml($response->body());
    }

    private function fetchFromOpenGraph(string $permalink): ?string
    {
        $response = Http::timeout(10)
            ->withHeaders($this->browserHeaders())
            ->get($permalink);

        if (! $response->successful()) {
            return null;
        }

        return $this->extractOgImageFromHtml($response->body());
    }

    private function extractOgImageFromHtml(string $html): ?string
    {
        if (preg_match('/property=["\']og:image["\']\s+content=["\']([^"\']+)["\']/i', $html, $matches)) {
            return html_entity_decode($matches[1], ENT_QUOTES);
        }

        if (preg_match('/content=["\']([^"\']+)["\']\s+property=["\']og:image["\']/i', $html, $matches)) {
            return html_entity_decode($matches[1], ENT_QUOTES);
        }

        if (preg_match('/"display_url":"([^"]+)"/', $html, $matches)) {
            return stripcslashes($matches[1]);
        }

        return null;
    }

    private function looksLikeCdnImageUrl(string $url): bool
    {
        return str_contains($url, 'cdninstagram.com')
            || str_contains($url, 'fbcdn.net')
            || str_contains($url, 'instagram.');
    }

    /**
     * @return array<string, string>
     */
    private function browserHeaders(): array
    {
        return [
            'User-Agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/122.0.0.0 Safari/537.36',
            'Accept' => 'text/html,application/xhtml+xml,application/xml;q=0.9,image/avif,image/webp,image/apng,*/*;q=0.8',
            'Accept-Language' => 'en-AU,en;q=0.9',
        ];
    }
}
