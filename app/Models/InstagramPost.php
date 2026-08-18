<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class InstagramPost extends Model
{
    protected $fillable = [
        'caption',
        'image',
        'instagram_url',
        'is_active',
        'sort_order',
        'published_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'published_at' => 'datetime',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function imageUrl(): string
    {
        return asset('storage/'.$this->image);
    }

    public function deleteImageFile(): void
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            Storage::disk('public')->delete($this->image);
        }
    }

    protected static function booted(): void
    {
        static::deleting(function (InstagramPost $post): void {
            $post->deleteImageFile();
        });
    }
}
