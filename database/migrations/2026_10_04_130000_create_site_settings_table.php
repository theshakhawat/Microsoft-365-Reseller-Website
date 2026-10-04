<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('site_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->longText('value')->nullable();
            $table->string('group')->default('general');
            $table->timestamps();
        });

        // Insert initial default values matching current website content
        $defaults = [
            // General & Branding
            ['key' => 'site_name', 'value' => 'Microsoft Office Club', 'group' => 'general'],
            ['key' => 'site_title', 'value' => 'Microsoft Office Club | Official Subscriptions & Cloud Licensing Bangladesh', 'group' => 'general'],
            ['key' => 'site_tagline', 'value' => 'Authorized Microsoft 365 cloud subscription provider in Bangladesh.', 'group' => 'general'],
            ['key' => 'header_logo', 'value' => 'assets/img/Microsoft Office Club Logo.png', 'group' => 'general'],
            ['key' => 'footer_logo', 'value' => 'assets/img/Microsoft Office Club Logo.png', 'group' => 'general'],
            ['key' => 'favicon', 'value' => 'assets/img/favicon.png', 'group' => 'general'],
            ['key' => 'top_announcement_enabled', 'value' => '1', 'group' => 'general'],
            ['key' => 'top_announcement_text', 'value' => 'Official Microsoft Reseller • Purchase plan via bKash, Nagad & Cards', 'group' => 'general'],
            ['key' => 'top_announcement_link', 'value' => 'https://wa.me/8801342325558', 'group' => 'general'],
            ['key' => 'top_announcement_link_text', 'value' => 'WhatsApp Helpline: +880 1342-325558', 'group' => 'general'],

            // Contact & Support
            ['key' => 'contact_address', 'value' => 'Gulshan-2 / Motijheel, Dhaka, Bangladesh', 'group' => 'contact'],
            ['key' => 'contact_phone', 'value' => '09649-0123756', 'group' => 'contact'],
            ['key' => 'contact_phone_raw', 'value' => '+88096490123756', 'group' => 'contact'],
            ['key' => 'contact_email', 'value' => 'support@cloudsync.com.bd', 'group' => 'contact'],
            ['key' => 'whatsapp_number', 'value' => '+880 1342-325558', 'group' => 'contact'],
            ['key' => 'whatsapp_raw_number', 'value' => '8801342325558', 'group' => 'contact'],
            ['key' => 'whatsapp_chat_message', 'value' => 'Hello I want to order Microsoft 365 Subscription', 'group' => 'contact'],
            ['key' => 'support_status_badge', 'value' => 'Support Available 24/7', 'group' => 'contact'],
            ['key' => 'support_hours', 'value' => '24/7 Mon-Sun Dedicated Cloud Support', 'group' => 'contact'],

            // Social Media Links
            ['key' => 'social_whatsapp', 'value' => 'https://wa.me/8801342325558', 'group' => 'social'],
            ['key' => 'social_facebook', 'value' => 'https://facebook.com', 'group' => 'social'],
            ['key' => 'social_linkedin', 'value' => 'https://linkedin.com', 'group' => 'social'],
            ['key' => 'social_twitter', 'value' => 'https://x.com', 'group' => 'social'],
            ['key' => 'social_youtube', 'value' => '', 'group' => 'social'],
            ['key' => 'social_instagram', 'value' => '', 'group' => 'social'],

            // Footer Specific Settings
            ['key' => 'footer_about_text', 'value' => 'Authorized Microsoft 365 cloud subscription provider in Bangladesh. Genuine cloud licensing, automated activation, local BDT checkout with bKash & Nagad, and 24/7 dedicated support.', 'group' => 'footer'],
            ['key' => 'footer_copyright_text', 'value' => '© 2026 Microsoft 365 Reseller Bangladesh. All rights reserved.', 'group' => 'footer'],
            ['key' => 'footer_disclaimer_text', 'value' => 'Microsoft, Microsoft 365, Office 365, Word, Excel, PowerPoint, Outlook, Teams, OneDrive, and Copilot are registered trademarks of Microsoft Corporation. We are an authorized cloud solution provider & reseller.', 'group' => 'footer'],
            ['key' => 'accepted_payment_methods_text', 'value' => 'bKash (Personal & Merchant), Nagad, Visa / Mastercard / AMEX', 'group' => 'footer'],
            ['key' => 'floating_whatsapp_enabled', 'value' => '1', 'group' => 'footer'],
            ['key' => 'floating_whatsapp_button_text', 'value' => 'WhatsApp Support', 'group' => 'footer'],

            // SEO & Scripts
            ['key' => 'meta_title', 'value' => 'Microsoft 365 Official Subscriptions Bangladesh | Genuine Cloud Licensing', 'group' => 'seo'],
            ['key' => 'meta_description', 'value' => 'Official Microsoft 365, Office Apps, and Copilot AI subscription reseller in Bangladesh. Instant BDT payment via bKash/Nagad, automated license provisioning, and 24/7 Dhaka support.', 'group' => 'seo'],
            ['key' => 'meta_keywords', 'value' => 'microsoft 365 bangladesh, buy office 365 dhaka, genuine microsoft license, bkash payment microsoft, copilot ai bangladesh', 'group' => 'seo'],
            ['key' => 'meta_author', 'value' => 'Microsoft Office Club Bangladesh', 'group' => 'seo'],
            ['key' => 'og_title', 'value' => 'Microsoft 365 Official Subscriptions Bangladesh', 'group' => 'seo'],
            ['key' => 'og_description', 'value' => 'Get genuine Microsoft 365 cloud subscriptions with instant activation and local BDT payment.', 'group' => 'seo'],
            ['key' => 'og_image', 'value' => 'assets/img/Microsoft Office Club Logo.png', 'group' => 'seo'],
            ['key' => 'twitter_card', 'value' => 'summary_large_image', 'group' => 'seo'],
            ['key' => 'google_analytics_id', 'value' => '', 'group' => 'seo'],
            ['key' => 'custom_head_scripts', 'value' => '', 'group' => 'seo'],
            ['key' => 'custom_footer_scripts', 'value' => '', 'group' => 'seo'],
        ];

        $now = now();
        foreach ($defaults as &$item) {
            $item['created_at'] = $now;
            $item['updated_at'] = $now;
        }

        DB::table('site_settings')->insert($defaults);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('site_settings');
    }
};
