<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Project extends Model
{
    protected $fillable = [
        'project_category_id',
        'name',
        'slug',
        'image',
        'is_exclusive_access',
        'featured_on_home',
        'sort_order',
    ];

    protected $casts = [
        'is_exclusive_access' => 'boolean',
        'featured_on_home' => 'boolean',
    ];

    public function scopeFeaturedOnHome($query)
    {
        return $query->where('featured_on_home', true);
    }

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }

    /**
     * Public URL for the project image. Uses /media/projects/… so images load even when
     * /storage symlink or server rules cause 403 on the live site.
     */
    protected function publicImageUrl(): Attribute
    {
        return Attribute::get(function (): ?string {
            if (! $this->image) {
                return null;
            }

            if (preg_match('#^projects/[^/]+$#', $this->image)) {
                return route('media.project_image', ['filename' => basename($this->image)], absolute: false);
            }

            return asset('storage/'.$this->image);
        });
    }
}
