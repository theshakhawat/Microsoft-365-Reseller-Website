<?php

namespace Database\Seeders;

use App\Models\PricingPlan;
use Illuminate\Database\Seeder;

class PricingPlanSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PricingPlan::updateOrCreate(
            ['name' => 'Microsoft 365 Basic'],
            [
                'badge'            => null,
                'price_bdt'        => '৳2,490',
                'billing_period'   => 'year',
                'price_usd'        => '$19.99/yr',
                'terms_text'       => 'Subscription automatically renews unless canceled in Microsoft account. See terms.',
                'button_text'      => 'Buy now',
                'button_url'       => 'https://wa.me/8801342325558?text=Hello%20I%20want%20to%20buy%20Microsoft%20365%20Basic%20Annual%20Plan',
                'features_heading' => 'Microsoft 365 Basic includes:',
                'features'         => [
                    'For 1 person',
                    'Works on web, iOS, and Android',
                    '100 GB of secure cloud storage',
                    'OneDrive ransomware protection for your photos and files',
                    'Outlook ad-free secure email',
                    'Ongoing support for help when you need it',
                ],
                'included_apps'    => ['onedrive', 'outlook'],
                'is_featured'      => false,
                'is_active'        => true,
                'sort_order'       => 1,
            ]
        );

        PricingPlan::updateOrCreate(
            ['name' => 'Microsoft 365 Personal'],
            [
                'badge'            => 'Most Popular',
                'price_bdt'        => '৳6,500',
                'billing_period'   => 'year',
                'price_usd'        => '$99.99/yr',
                'terms_text'       => 'Subscription automatically renews unless canceled in Microsoft account. See terms.',
                'button_text'      => 'Buy now',
                'button_url'       => 'https://wa.me/8801342325558?text=Hello%20I%20want%20to%20buy%20Microsoft%20365%20Personal%20Annual%20Plan',
                'features_heading' => 'Everything in Basic, plus:',
                'features'         => [
                    'Use on up to 5 devices simultaneously',
                    'Works on PC, Mac, iPhone, iPad, and Android phones and tablets',
                    '1 TB (1000 GB) of secure cloud storage',
                    'Word, Excel, PowerPoint, Outlook, and OneNote desktop apps with Microsoft Copilot',
                    'Higher usage limits than free for select Copilot features',
                    'Use Copilot in select apps with work files in a secure way',
                    'Higher usage for AI image creation in Copilot',
                    'Microsoft Defender advanced security for your identity & devices',
                    'Microsoft Teams with Copilot to call, chat, and collaborate',
                ],
                'included_apps'    => ['copilot', 'word', 'excel', 'powerpoint', 'outlook', 'teams', 'onedrive', 'defender'],
                'is_featured'      => true,
                'is_active'        => true,
                'sort_order'       => 2,
            ]
        );
    }
}
