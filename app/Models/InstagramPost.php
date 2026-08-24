<?php

namespace App\Models;

use App\Services\InstagramThumbnailService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class InstagramPost extends Model
{
    protected $fillable = [
        'instagram_url',
        'embed_code',
        'thumbnail_url',
        'admin_note',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function hasLocalThumbnail(): bool
    {
        return app(InstagramThumbnailService::class)->isLocalPath($this->thumbnail_url)
            && Storage::disk('public')->exists($this->thumbnail_url);
    }

    public function displayImageUrl(): string
    {
        // Always serve through Laravel media route so local files work without
        // relying on a public/storage symlink, and expired CDN URLs can be refreshed.
        return route('media.instagram_post', $this, absolute: false);
    }

    public function adminInputValue(): string
    {
        return $this->embed_code ?: $this->instagram_url;
    }

    protected static function booted(): void
    {
        static::deleting(function (InstagramPost $post): void {
            app(InstagramThumbnailService::class)->deleteLocalFile($post->thumbnail_url);
        });
    }
}
