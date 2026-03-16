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
        'sort_order',
    ];

    protected $casts = [
        'is_exclusive_access' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ProjectCategory::class, 'project_category_id');
    }
}
