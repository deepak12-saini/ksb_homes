<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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

    public function displayImageUrl(): string
    {
        if ($this->thumbnail_url) {
            return $this->thumbnail_url;
        }

        return route('media.instagram_post', $this, absolute: false);
    }

    public function adminInputValue(): string
    {
        return $this->embed_code ?: $this->instagram_url;
    }
}
