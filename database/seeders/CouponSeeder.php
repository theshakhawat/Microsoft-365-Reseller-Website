<?php

namespace Database\Seeders;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class CouponSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $coupons = [
            [
                'code'                => 'WELCOME10',
                'name'                => 'New User Welcome Bonus',
                'description'         => '10% discount on all Microsoft 365 plans for new customers.',
                'discount_type'       => 'percentage',
                'discount_value'      => 10.00,
                'min_order_amount'    => null,
                'max_discount_amount' => 500.00,
                'start_date'          => Carbon::now()->subDays(5),
                'expire_date'         => Carbon::now()->addMonths(6),
                'max_uses'            => 500,
                'max_uses_per_user'   => 1,
                'used_count'          => 12,
                'is_active'           => true,
            ],
            [
                'code'                => 'EID500',
                'name'                => 'Special Eid Flat Discount',
                'description'         => 'Flat ৳500 instant discount on yearly subscriptions.',
                'discount_type'       => 'fixed',
                'discount_value'      => 500.00,
                'min_order_amount'    => 2000.00,
                'max_discount_amount' => null,
                'start_date'          => Carbon::now()->subDays(1),
                'expire_date'         => Carbon::now()->addDays(30),
                'max_uses'            => 100,
                'max_uses_per_user'   => 1,
                'used_count'          => 8,
                'is_active'           => true,
            ],
            [
                'code'                => 'OFFICE25',
                'name'                => 'Flash Sale 25% Off',
                'description'         => 'Exclusive 25% discount on Family and Business plans.',
                'discount_type'       => 'percentage',
                'discount_value'      => 25.00,
                'min_order_amount'    => 1500.00,
                'max_discount_amount' => 1000.00,
                'start_date'          => Carbon::now()->subDays(10),
                'expire_date'         => Carbon::now()->addDays(15),
                'max_uses'            => 50,
                'max_uses_per_user'   => 1,
                'used_count'          => 45,
                'is_active'           => true,
            ],
            [
                'code'                => 'EXPIRED20',
                'name'                => 'Old Campaign Discount',
                'description'         => 'Previous promotional coupon that has expired.',
                'discount_type'       => 'percentage',
                'discount_value'      => 20.00,
                'min_order_amount'    => 1000.00,
                'max_discount_amount' => null,
                'start_date'          => Carbon::now()->subMonths(2),
                'expire_date'         => Carbon::now()->subDays(10),
                'max_uses'            => 100,
                'max_uses_per_user'   => 1,
                'used_count'          => 100,
                'is_active'           => true,
            ],
        ];

        foreach ($coupons as $coupon) {
            Coupon::updateOrCreate(
                ['code' => $coupon['code']],
                $coupon
            );
        }
    }
}
