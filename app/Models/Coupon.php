<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
        'description',
        'discount_type',
        'discount_value',
        'min_order_amount',
        'max_discount_amount',
        'start_date',
        'expire_date',
        'max_uses',
        'max_uses_per_user',
        'used_count',
        'is_active',
    ];

    protected $casts = [
        'discount_value'      => 'decimal:2',
        'min_order_amount'    => 'decimal:2',
        'max_discount_amount' => 'decimal:2',
        'start_date'          => 'datetime',
        'expire_date'         => 'datetime',
        'max_uses'            => 'integer',
        'max_uses_per_user'   => 'integer',
        'used_count'          => 'integer',
        'is_active'           => 'boolean',
    ];

    /**
     * Get human-readable formatted discount string (e.g. 20% or ৳500 Flat).
     */
    public function getFormattedDiscountAttribute(): string
    {
        if ($this->discount_type === 'percentage') {
            return rtrim(rtrim(number_format($this->discount_value, 2), '0'), '.') . '% Off';
        }

        return '৳' . number_format($this->discount_value, 0) . ' Flat';
    }

    /**
     * Check if the coupon is expired.
     */
    public function getIsExpiredAttribute(): bool
    {
        return $this->expire_date && $this->expire_date->isPast();
    }

    /**
     * Check if the coupon has not started yet.
     */
    public function getIsUpcomingAttribute(): bool
    {
        return $this->start_date && $this->start_date->isFuture();
    }

    /**
     * Check if coupon usage limit is reached.
     */
    public function getIsExhaustedAttribute(): bool
    {
        return $this->max_uses !== null && $this->used_count >= $this->max_uses;
    }

    /**
     * Get computed badge status string.
     */
    public function getComputedStatusAttribute(): string
    {
        if (!$this->is_active) {
            return 'inactive';
        }

        if ($this->is_expired) {
            return 'expired';
        }

        if ($this->is_upcoming) {
            return 'upcoming';
        }

        if ($this->is_exhausted) {
            return 'exhausted';
        }

        return 'active';
    }

    /**
     * Determine if coupon is currently valid for usage.
     */
    public function isValid(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        if ($this->is_expired || $this->is_upcoming || $this->is_exhausted) {
            return false;
        }

        return true;
    }

    /**
     * Calculate discount amount for a given order total.
     */
    public function calculateDiscount(float $orderTotal): float
    {
        if ($this->min_order_amount && $orderTotal < $this->min_order_amount) {
            return 0.0;
        }

        if ($this->discount_type === 'percentage') {
            $discount = ($orderTotal * $this->discount_value) / 100;
            if ($this->max_discount_amount && $discount > $this->max_discount_amount) {
                $discount = $this->max_discount_amount;
            }
            return round($discount, 2);
        }

        return min($orderTotal, (float) $this->discount_value);
    }
}
