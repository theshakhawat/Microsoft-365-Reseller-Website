<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PricingPlan extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'badge',
        'price_bdt',
        'billing_period',
        'price_usd',
        'terms_text',
        'button_text',
        'button_url',
        'features_heading',
        'features',
        'included_apps',
        'is_featured',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'features'      => 'array',
        'included_apps' => 'array',
        'is_featured'   => 'boolean',
        'is_active'     => 'boolean',
        'sort_order'    => 'integer',
    ];
}
