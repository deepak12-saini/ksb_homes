<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class ProjectImage extends Model
{
    protected $fillable = [
        'project_id',
        'path',
        'sort_order',
    ];

    protected $casts = [
        'sort_order' => 'integer',
    ];

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Public URL for a gallery render. Uses /media/projects/… when stored under projects/.
     */
    protected function publicUrl(): Attribute
    {
        return Attribute::get(function (): ?string {
            if (! $this->path) {
                return null;
            }

            if (preg_match('#^projects/[^/]+$#', $this->path)) {
                return route('media.project_image', ['filename' => basename($this->path)], absolute: false);
            }

            return asset('storage/'.$this->path);
        });
    }

    public function deleteStoredFile(): void
    {
        if ($this->path && Storage::disk('public')->exists($this->path)) {
            Storage::disk('public')->delete($this->path);
        }
    }

    protected static function booted(): void
    {
        static::deleting(function (ProjectImage $image): void {
            $image->deleteStoredFile();
        });
    }
}
