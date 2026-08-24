<?php

namespace App\Console\Commands;

use App\Models\InstagramPost;
use App\Services\InstagramThumbnailService;
use Illuminate\Console\Command;

class StoreInstagramThumbnailsLocally extends Command
{
    protected $signature = 'instagram:store-thumbnails {--force : Re-download even when a local file already exists}';

    protected $description = 'Download Instagram post thumbnails to local storage so CDN URLs do not expire';

    public function handle(InstagramThumbnailService $service): int
    {
        $posts = InstagramPost::query()->orderBy('id')->get();

        if ($posts->isEmpty()) {
            $this->info('No Instagram posts found.');

            return self::SUCCESS;
        }

        $ok = 0;
        $skipped = 0;
        $failed = 0;

        foreach ($posts as $post) {
            if (! $this->option('force') && $post->hasLocalThumbnail()) {
                $skipped++;
                $this->line("Skipped #{$post->id} (already local)");

                continue;
            }

            $path = $service->storeLocalThumbnail($post->instagram_url, $post->thumbnail_url);

            if ($path) {
                $post->update(['thumbnail_url' => $path]);
                $ok++;
                $this->info("Saved #{$post->id} → {$path}");
            } else {
                $failed++;
                $this->error("Failed #{$post->id} ({$post->instagram_url})");
            }
        }

        $this->newLine();
        $this->info("Done. Saved: {$ok}, skipped: {$skipped}, failed: {$failed}");

        return $failed > 0 ? self::FAILURE : self::SUCCESS;
    }
}
