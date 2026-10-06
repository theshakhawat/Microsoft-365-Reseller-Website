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
                'name'        => 'MoneyBag',
                'slug'        => 'moneybag',
                'logo'        => 'assets/img/logo_moneybag.png',
                'instruction' => 'Fast digital wallet payment and instant invoice clearance.',
                'sort_order'  => 3,
                'status'      => true,
                'base_url' => 'https://api.moneybag.com.bd/api/v2',
                'merchant_key' => '28703f05.gX9WxeKNcyrtWIuREbhPPpX2YL5Qhv4EMZd2UZFVgM4',
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
