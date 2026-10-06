<?php

namespace Database\Seeders;

use App\Models\Faq;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CleanUploadedFilesSeeder::class,
            AdminSeeder::class,
            PricingPlanSeeder::class,
            KeyFeatureSeeder::class,
            IncludedAppSeeder::class,
            HowItWorkSeeder::class,
            AiFeatureSeeder::class,
            FaqSeeder::class,
            MoreBenefitSeeder::class,
            TrustedBrandSeeder::class,
            CouponSeeder::class,
            PaymentMethodSeeder::class,
        ]);
    }
}
