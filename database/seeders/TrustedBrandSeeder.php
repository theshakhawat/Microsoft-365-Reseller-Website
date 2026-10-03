<?php

namespace Database\Seeders;

use App\Models\TrustedBrand;
use Illuminate\Database\Seeder;

class TrustedBrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $brands = [
            [
                'name' => 'Coca-Cola',
                'logo_image' => 'assets/img/brands/coca-cola.svg',
                'website_url' => 'https://www.coca-cola.com',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'Toyota',
                'logo_image' => 'assets/img/brands/toyota.svg',
                'website_url' => 'https://www.toyota.com',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Nike',
                'logo_image' => 'assets/img/brands/nike.svg',
                'website_url' => 'https://www.nike.com',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'name' => 'Intel',
                'logo_image' => 'assets/img/brands/intel.svg',
                'website_url' => 'https://www.intel.com',
                'sort_order' => 4,
                'is_active' => true,
            ],
            [
                'name' => 'Samsung',
                'logo_image' => 'assets/img/brands/samsung.svg',
                'website_url' => 'https://www.samsung.com',
                'sort_order' => 5,
                'is_active' => true,
            ],
            [
                'name' => 'BMW',
                'logo_image' => 'assets/img/brands/bmw.svg',
                'website_url' => 'https://www.bmw.com',
                'sort_order' => 6,
                'is_active' => true,
            ],
            [
                'name' => 'Accenture',
                'logo_image' => 'assets/img/brands/accenture.svg',
                'website_url' => 'https://www.accenture.com',
                'sort_order' => 7,
                'is_active' => true,
            ],
            [
                'name' => 'Walmart',
                'logo_image' => 'assets/img/brands/walmart.svg',
                'website_url' => 'https://www.walmart.com',
                'sort_order' => 8,
                'is_active' => true,
            ],
            [
                'name' => 'Unilever',
                'logo_image' => 'assets/img/brands/unilever.svg',
                'website_url' => 'https://www.unilever.com',
                'sort_order' => 9,
                'is_active' => true,
            ],
        ];

        foreach ($brands as $brand) {
            TrustedBrand::updateOrCreate(
                ['name' => $brand['name']],
                $brand
            );
        }
    }
}
