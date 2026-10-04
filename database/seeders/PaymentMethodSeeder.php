<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name'        => 'bKash',
                'slug'        => 'bkash',
                'logo'        => 'https://raw.githubusercontent.com/Shakhawat9083/assets/main/bkash-logo.png',
                'instruction' => 'Pay securely via bKash personal or merchant account. Instant order confirmation.',
                'sort_order'  => 1,
                'status'      => true,
            ],
            [
                'name'        => 'Nagad',
                'slug'        => 'nagad',
                'logo'        => 'https://raw.githubusercontent.com/Shakhawat9083/assets/main/nagad-logo.png',
                'instruction' => 'Fast payment through Nagad wallet or mobile number with automatic verification.',
                'sort_order'  => 2,
                'status'      => true,
            ],
            [
                'name'        => 'MoneyBag',
                'slug'        => 'moneybag',
                'logo'        => null,
                'instruction' => 'Fast digital wallet payment and instant invoice clearance.',
                'sort_order'  => 3,
                'status'      => true,
            ],
            [
                'name'        => 'PayPal International',
                'slug'        => 'paypal',
                'logo'        => null,
                'instruction' => 'International credit cards and PayPal balance payments in USD.',
                'sort_order'  => 4,
                'status'      => true,
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::updateOrCreate(
                ['slug' => $method['slug']],
                $method
            );
        }
    }
}
