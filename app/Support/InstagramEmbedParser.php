<?php

namespace App\Support;

use InvalidArgumentException;

class InstagramEmbedParser
{
    /**
     * @return array{instagram_url: string, embed_code: string|null}
     */
    public static function parse(string $input): array
    {
        $input = trim($input);

        if ($input === '') {
            throw new InvalidArgumentException('Please paste an Instagram embed code or post URL.');
        }

        if (str_contains($input, 'instagram-media') || str_contains($input, 'data-instgrm-permalink')) {
            $permalink = self::extractPermalinkFromEmbed($input);

            if ($permalink === null) {
                throw new InvalidArgumentException('Could not find a valid Instagram post URL in the embed code.');
            }

            return [
                'instagram_url' => self::normalizePermalink($permalink),
                'embed_code' => $input,
            ];
        }

        $permalink = self::extractPermalinkFromUrl($input);

        if ($permalink === null) {
            throw new InvalidArgumentException('Please paste a valid Instagram post URL or embed code.');
        }

        return [
            'instagram_url' => $permalink,
            'embed_code' => null,
        ];
    }

    public static function normalizePermalink(string $url): string
    {
        $url = trim(html_entity_decode($url, ENT_QUOTES));

        if (preg_match('#(https?://(?:www\.)?instagram\.com/(?:p|reel|tv)/[\w-]+)/?(?:\?.*)?$#i', $url, $matches)) {
            return rtrim($matches[1], '/').'/';
        }

        if (! str_starts_with($url, 'http')) {
            $url = 'https://'.$url;
        }

        return rtrim($url, '/').'/';
    }

    private static function extractPermalinkFromEmbed(string $input): ?string
    {
        if (preg_match('/data-instgrm-permalink=["\']([^"\']+)["\']/i', $input, $matches)) {
            return html_entity_decode($matches[1], ENT_QUOTES);
        }

        if (preg_match('#https?://(?:www\.)?instagram\.com/(?:p|reel|tv)/[\w-]+/?#i', $input, $matches)) {
            return $matches[0];
        }

        return null;
    }

    private static function extractPermalinkFromUrl(string $input): ?string
    {
        if (preg_match('#https?://(?:www\.)?instagram\.com/(?:p|reel|tv)/[\w-]+/?#i', $input, $matches)) {
            return self::normalizePermalink($matches[0]);
        }

        return null;
    }
}
