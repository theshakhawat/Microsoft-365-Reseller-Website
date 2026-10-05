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
                'name' => 'Dhaka International University',
                'logo_image' => 'assets/img/brands/diu.png',
                'website_url' => 'https://www.diu.ac',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'name' => 'American International University-Bangladesh',
                'logo_image' => 'assets/img/brands/aiub.png',
                'website_url' => 'https://www.aiub.edu',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'name' => 'Daffodil International University',
                'logo_image' => 'assets/img/brands/daffodil.png',
                'website_url' => 'https://www.daffodilvarsity.edu.bd',
                'sort_order' => 3,
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
