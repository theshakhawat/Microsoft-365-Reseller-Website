<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HowItWork extends Model
{
    use HasFactory;

    protected $table = 'how_it_works';

    protected $fillable = [
        'step_number',
        'title',
        'description',
        'icon',
        'icon_bg_color',
        'badge_text',
        'badge_icon',
        'badge_color',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];
}
