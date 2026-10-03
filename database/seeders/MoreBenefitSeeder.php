<?php

namespace Database\Seeders;

use App\Models\MoreBenefit;
use Illuminate\Database\Seeder;

class MoreBenefitSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $benefits = [
            [
                'title'       => 'Powerful productivity apps with AI',
                'description' => 'Streamline your day with desktop versions of apps like Word, Excel, PowerPoint, Outlook, and OneNote integrated with Microsoft Copilot.',
                'icon_image'  => 'assets/img/products/copilot.png',
                'sort_order'  => 1,
                'is_active'   => true,
            ],
            [
                'title'       => 'Simplify your online security',
                'description' => 'Keep you and your family safer online with continuous monitoring for threats, real-time alerts, tips, and expert guidance from Microsoft Defender.',
                'icon_image'  => 'assets/img/products/defender.png',
                'sort_order'  => 2,
                'is_active'   => true,
            ],
            [
                'title'       => 'Trusted storage for priceless memories',
                'description' => 'Quickly save, share, and edit your photos and files with 1 TB (1000 GB) OneDrive secure cloud and Microsoft 365 ransomware protection.',
                'icon_image'  => 'assets/img/products/onedrive.png',
                'sort_order'  => 3,
                'is_active'   => true,
            ],
            [
                'title'       => 'Make the most of your day',
                'description' => 'With Outlook as command central, you can spend less time organizing your life and more time enjoying it with ad-free unified inbox & calendar.',
                'icon_image'  => 'assets/img/products/outlook.png',
                'sort_order'  => 4,
                'is_active'   => true,
            ],
            [
                'title'       => 'All your ideas in one place',
                'description' => 'Capture inspiration in text, audio, photos, and sketches to create your next big project and access them across all your synced devices.',
                'icon_image'  => 'assets/img/products/word.png',
                'sort_order'  => 5,
                'is_active'   => true,
            ],
            [
                'title'       => 'All-day HD video calling & chat',
                'description' => 'Join group calls and talk for up to 30 hours with up to 300 people with Microsoft Teams, built-in screen sharing, and noise suppression.',
                'icon_image'  => 'assets/img/products/teams.png',
                'sort_order'  => 6,
                'is_active'   => true,
            ],
        ];

        foreach ($benefits as $benefit) {
            MoreBenefit::updateOrCreate(
                ['title' => $benefit['title']],
                $benefit
            );
        }
    }
}
