<?php

namespace Database\Seeders;

use App\Models\KeyFeature;
use Illuminate\Database\Seeder;

class KeyFeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = [
            [
                'title'         => 'Copilot AI Integration',
                'description'   => 'Supercharge your productivity across Word, Excel, PowerPoint, and Outlook with advanced AI assistance.',
                'icon'          => 'fa-solid fa-wand-magic-sparkles',
                'icon_bg_color' => 'purple',
                'link_url'      => '#plans',
                'link_text'     => 'Learn more',
                'sort_order'    => 1,
                'is_active'     => true,
            ],
            [
                'title'         => '1 TB Secure Cloud Storage',
                'description'   => 'Keep your photos, files, and documents safely backed up in OneDrive with ransomware protection and device sync.',
                'icon'          => 'fa-solid fa-cloud',
                'icon_bg_color' => 'blue',
                'link_url'      => '#plans',
                'link_text'     => 'Learn more',
                'sort_order'    => 2,
                'is_active'     => true,
            ],
            [
                'title'         => 'Full Desktop & Mobile Apps',
                'description'   => 'Install premium Office apps on up to 5 devices per user across Windows, Mac, iOS, and Android.',
                'icon'          => 'fa-solid fa-laptop-code',
                'icon_bg_color' => 'emerald',
                'link_url'      => '#plans',
                'link_text'     => 'Learn more',
                'sort_order'    => 3,
                'is_active'     => true,
            ],
        ];

        foreach ($features as $feature) {
            KeyFeature::updateOrCreate(
                ['title' => $feature['title']],
                $feature
            );
        }
    }
}
