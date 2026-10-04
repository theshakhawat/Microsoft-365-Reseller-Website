<?php

namespace Database\Seeders;

use App\Models\IncludedApp;
use Illuminate\Database\Seeder;

class IncludedAppSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $apps = [
            // Productivity Apps
            [
                'category'    => 'productivity',
                'name'        => 'Microsoft Word',
                'tagline'     => 'Documents & Editing',
                'description' => 'Elevate your writing and create beautiful documents anywhere, anytime with intelligent formatting and Copilot assistance.',
                'icon_image'  => 'assets/img/products/word.png',
                'link_url'    => '#plans',
                'link_text'   => 'Explore Word',
                'sort_order'  => 1,
                'is_active'   => true,
            ],
            [
                'category'    => 'productivity',
                'name'        => 'Microsoft Excel',
                'tagline'     => 'Spreadsheets & Analysis',
                'description' => 'Transform data into actionable insights with powerful formulas, modern charts, and AI-driven predictive modeling.',
                'icon_image'  => 'assets/img/products/excel.png',
                'link_url'    => '#plans',
                'link_text'   => 'Explore Excel',
                'sort_order'  => 2,
                'is_active'   => true,
            ],
            [
                'category'    => 'productivity',
                'name'        => 'Microsoft PowerPoint',
                'tagline'     => 'Presentations & Slides',
                'description' => 'Design captivating, professional presentations effortlessly using AI Designer and modern animations.',
                'icon_image'  => 'assets/img/products/powerpoint.png',
                'link_url'    => '#plans',
                'link_text'   => 'Explore PowerPoint',
                'sort_order'  => 3,
                'is_active'   => true,
            ],
            [
                'category'    => 'productivity',
                'name'        => 'Microsoft Outlook',
                'tagline'     => 'Email & Calendars',
                'description' => 'Stay organized with connected email, calendar, tasks, and contacts in one streamlined, secure inbox.',
                'icon_image'  => 'assets/img/products/outlook.png',
                'link_url'    => '#plans',
                'link_text'   => 'Explore Outlook',
                'sort_order'  => 4,
                'is_active'   => true,
            ],

            // Security & Cloud Storage
            [
                'category'    => 'security',
                'name'        => 'OneDrive Cloud',
                'tagline'     => '1 TB Secure Storage',
                'description' => 'Secure cloud storage with automated photo backup, file sharing, and Personal Vault encryption.',
                'icon_image'  => 'assets/img/products/onedrive.png',
                'link_url'    => '#plans',
                'link_text'   => 'Explore OneDrive',
                'sort_order'  => 1,
                'is_active'   => true,
            ],
            [
                'category'    => 'security',
                'name'        => 'Microsoft Defender',
                'tagline'     => 'Advanced Security',
                'description' => 'Cross-device security app that helps safeguard your personal data and devices against malware.',
                'icon_image'  => 'assets/img/products/defender.png',
                'link_url'    => '#plans',
                'link_text'   => 'Explore Defender',
                'sort_order'  => 2,
                'is_active'   => true,
            ],
            [
                'category'    => 'security',
                'name'        => 'Microsoft Teams',
                'tagline'     => 'Meetings & Chats',
                'description' => 'Connect, collaborate, and call with crystal clear audio/video and integrated file sharing.',
                'icon_image'  => 'assets/img/products/teams.png',
                'link_url'    => '#plans',
                'link_text'   => 'Explore Teams',
                'sort_order'  => 3,
                'is_active'   => true,
            ],
        ];

        foreach ($apps as $app) {
            IncludedApp::updateOrCreate(
                ['name' => $app['name'], 'category' => $app['category']],
                $app
            );
        }
    }
}
