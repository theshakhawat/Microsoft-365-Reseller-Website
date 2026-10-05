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
