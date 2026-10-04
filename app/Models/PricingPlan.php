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

    /**
     * Get numeric price in BDT extracted from price_bdt string.
     * E.g. "৳2,490" => 2490.00
     */
    public function getNumericPriceAttribute(): float
    {
        $clean = preg_replace('/[^\d.]/', '', (string) $this->price_bdt);
        return (float) ($clean ?: 0);
    }

    /**
     * Get all orders for this plan.
     */
    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Get all subscriptions for this plan.
     */
    public function subscriptions(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Subscription::class);
    }
}
