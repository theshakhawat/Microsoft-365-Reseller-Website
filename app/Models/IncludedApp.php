<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IncludedApp extends Model
{
    use HasFactory;

    protected $table = 'included_apps';

    protected $fillable = [
        'category',
        'name',
        'tagline',
        'description',
        'icon_image',
        'link_url',
        'link_text',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
