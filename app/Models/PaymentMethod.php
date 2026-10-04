<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentMethod extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'logo',
        'instruction',
        'merchant_key',
        'base_url',
        'api_secret',
        'mode',
        'additional_settings',
        'sort_order',
        'status',
    ];

    protected $casts = [
        'status'              => 'boolean',
        'sort_order'          => 'integer',
        'additional_settings' => 'array',
    ];

    /**
     * Get logo full URL or asset path.
     */
    public function getLogoUrlAttribute(): ?string
    {
        if (empty($this->logo)) {
            return null;
        }

        if (str_starts_with($this->logo, 'http://') || str_starts_with($this->logo, 'https://')) {
            return $this->logo;
        }

        return asset($this->logo);
    }

    /**
     * Get orders placed using this payment method.
     */
    public function orders(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Order::class);
    }
}

