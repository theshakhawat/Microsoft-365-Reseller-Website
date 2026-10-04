<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_number',
        'user_id',
        'pricing_plan_id',
        'payment_method_id',
        'plan_name',
        'payment_method_slug',
        'plan_price',
        'coupon_code',
        'discount_amount',
        'payable_amount',
        'recipient_name',
        'recipient_email',
        'recipient_phone',
        'notes',
        'payment_status',
        'gateway_txn_id',
        'gateway_txn_number',
        'gateway_response',
        'paid_at',
    ];

    protected $casts = [
        'plan_price'      => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'payable_amount'  => 'decimal:2',
        'paid_at'         => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function pricingPlan(): BelongsTo
    {
        return $this->belongsTo(PricingPlan::class);
    }

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }
}
