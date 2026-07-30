<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Storage;

class Project extends Model
{
    protected $fillable = [
        'project_category_id',
        'name',
        'slug',
        'image',
        'architecture',
        'location',
        'status',
        'property_type',
        'no',
        'levels',
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

    public function images(): HasMany
    {
        return $this->hasMany(ProjectImage::class)->orderBy('sort_order')->orderBy('id');
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

    /**
     * Main image first, then gallery renders — for detail page and SEO schema.
     *
     * @return list<string>
     */
    public function allPublicImageUrls(): array
    {
        $urls = [];

        if ($this->public_image_url) {
            $urls[] = $this->public_image_url;
        }

        foreach ($this->images as $image) {
            if ($image->public_url) {
                $urls[] = $image->public_url;
            }
        }

        return array_values(array_unique($urls));
    }

    public function deleteMainImageFile(): void
    {
        if ($this->image && Storage::disk('public')->exists($this->image)) {
            Storage::disk('public')->delete($this->image);
        }
    }

    protected static function booted(): void
    {
        static::deleting(function (Project $project): void {
            $project->loadMissing('images');

            foreach ($project->images as $image) {
                $image->delete();
            }

            $project->deleteMainImageFile();
        });
    }
}
