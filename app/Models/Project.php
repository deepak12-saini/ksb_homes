<?php

namespace App\Models;

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
}
