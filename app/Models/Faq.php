<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Faq extends Model
{
    use HasFactory;

    protected $fillable = [
        'question',
        'answer',
        'sort_order',
        'is_default_open',
        'is_active',
    ];

    protected $casts = [
        'sort_order' => 'integer',
        'is_default_open' => 'boolean',
        'is_active' => 'boolean',
    ];
}
