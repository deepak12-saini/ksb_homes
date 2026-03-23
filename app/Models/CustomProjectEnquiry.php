<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomProjectEnquiry extends Model
{
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'postcode',
        'project_description',
    ];
}
