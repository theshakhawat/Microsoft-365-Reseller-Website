<?php

$knownLabels = [
    'bkash'            => 'bKash',
    'nagad'            => 'Nagad',
    'moneybag'         => 'MoneyBag',
    'paypal'           => 'PayPal',
    'rocket'           => 'Rocket',
    'upay'             => 'Upay',
    'sslcommerz'       => 'SSLCommerz',
    'aamarpay'         => 'AamarPay',
    'stripe'           => 'Stripe',
    'bank_transfer'    => 'Bank Transfer',
    'cash_on_delivery' => 'Cash On Delivery',
];

$rawMethods = env('Available_Payment_Mehtod') 
    ?? env('AVAILABLE_PAYMENT_METHODS') 
    ?? env('AVAILABLE_PAYMENT_METHOD') 
    ?? env('available_payment_methods') 
    ?? 'bkash,nagad,moneybag,paypal';

$slugs = array_values(array_filter(array_map('trim', explode(',', strtolower($rawMethods)))));

$availableMethods = [];
foreach ($slugs as $slug) {
    $availableMethods[$slug] = $knownLabels[$slug] ?? ucwords(str_replace(['_', '-'], ' ', $slug));
}

return [
    /*
    |--------------------------------------------------------------------------
    | Available Payment Gateways / Slugs
    |--------------------------------------------------------------------------
    |
    | Slugs defined in .env AVAILABLE_PAYMENT_METHODS for gateway drivers.
    |
    */
    'available_methods' => $availableMethods,
];

