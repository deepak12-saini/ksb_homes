<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class ContactEnquiry extends Model
{
    protected $fillable = [
        'full_name',
        'phone',
        'email',
        'suburb_postcode',
        'looking_to_do',
        'land_owner',
        'site_address',
        'project_type',
        'budget',
        'timeline',
        'project_stage',
        'project_goal',
        'estimated_project_value',
        'number_of_dwellings',
        'looking_for_partner',
        'hear_about_us',
        'hear_about_other',
        'message',
        'consent',
        'attachment_storage_path',
        'attachment_original_name',
    ];

    protected $casts = [
        'looking_to_do' => 'array',
        'consent' => 'boolean',
    ];

    public function hasAttachment(): bool
    {
        $path = $this->attachment_storage_path;
        if (! is_string($path) || $path === '') {
            return false;
        }

        return Storage::disk('public')->exists($path)
            || Storage::disk('local')->exists($path);
    }
}
