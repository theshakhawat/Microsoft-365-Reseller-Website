<?php

namespace Database\Seeders;

use App\Models\HowItWork;
use Illuminate\Database\Seeder;

class HowItWorkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $steps = [
            [
                'step_number'   => '01',
                'title'         => 'Choose Your Plan',
                'description'   => 'Select the genuine Microsoft 365 cloud subscription plan tailored for your individual usage, family sharing, or organization.',
                'icon'          => 'fa-solid fa-layer-group',
                'icon_bg_color' => 'sky',
                'badge_text'    => 'Instant Plan Selection',
                'badge_icon'    => 'fa-solid fa-circle-check',
                'badge_color'   => 'emerald',
                'sort_order'    => 1,
                'is_active'     => true,
            ],
            [
                'step_number'   => '02',
                'title'         => 'Local BDT Checkout',
                'description'   => 'Pay instantly in Bangladeshi Taka using bKash, Nagad, Rocket, or local & international cards with 100% security.',
                'icon'          => 'fa-solid fa-credit-card',
                'icon_bg_color' => 'emerald',
                'badge_text'    => 'bKash & Nagad Support',
                'badge_icon'    => 'fa-solid fa-shield-halved',
                'badge_color'   => 'emerald',
                'sort_order'    => 2,
                'is_active'     => true,
            ],
            [
                'step_number'   => '03',
                'title'         => 'Automated Provisioning',
                'description'   => 'Our system provisions your official Microsoft Partner account or links your existing email with authorized CSP credentials.',
                'icon'          => 'fa-solid fa-bolt',
                'icon_bg_color' => 'amber',
                'badge_text'    => 'Fast Cloud Setup',
                'badge_icon'    => 'fa-solid fa-bolt',
                'badge_color'   => 'amber',
                'sort_order'    => 3,
                'is_active'     => true,
            ],
            [
                'step_number'   => '04',
                'title'         => 'Enjoy & Download Apps',
                'description'   => 'Download full desktop & mobile apps (Word, Excel, PowerPoint), access 1TB OneDrive cloud, and unlock Copilot AI tools.',
                'icon'          => 'fa-solid fa-cloud-arrow-down',
                'icon_bg_color' => 'purple',
                'badge_text'    => '1TB Cloud & 24/7 Support',
                'badge_icon'    => 'fa-solid fa-headset',
                'badge_color'   => 'purple',
                'sort_order'    => 4,
                'is_active'     => true,
            ],
        ];

        foreach ($steps as $step) {
            HowItWork::updateOrCreate(
                ['title' => $step['title']],
                $step
            );
        }
    }
}
