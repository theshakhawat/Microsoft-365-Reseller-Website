<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminSiteSettingController extends Controller
{
    /**
     * Display the site settings management page.
     */
    public function index(Request $request)
    {
        $settings = SiteSetting::getAllSettings();
        $activeTab = $request->query('tab', 'general');

        return view('admin.settings.site', compact('settings', 'activeTab'));
    }

    /**
     * Update site settings.
     */
    public function update(Request $request)
    {
        $group = $request->input('group', 'general');

        // Validation based on group or general inputs
        $rules = [
            'site_name' => 'nullable|string|max:255',
            'site_title' => 'nullable|string|max:255',
            'site_tagline' => 'nullable|string|max:500',
            'header_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'footer_logo' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:4096',
            'favicon' => 'nullable|image|mimes:ico,png,jpg,svg,webp|max:2048',
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:100',
            'whatsapp_number' => 'nullable|string|max:100',
            'whatsapp_raw_number' => 'nullable|string|max:100',
        ];

        $request->validate($rules);

        // Process File Uploads
        $fileKeys = ['header_logo', 'footer_logo', 'favicon', 'og_image', 'hero_banner_image', 'hero_bg_image', 'cta_banner_bg_image'];
        foreach ($fileKeys as $fileKey) {
            if ($request->hasFile($fileKey)) {
                $file = $request->file($fileKey);
                $filename = $fileKey . '_' . time() . '.' . $file->getClientOriginalExtension();
                $path = $file->storeAs('settings', $filename, 'public');
                SiteSetting::set($fileKey, 'storage/' . $path, $group);
            }
        }

        // Process Text & Boolean Settings
        $fields = [
            // General
            'site_name' => 'general',
            'site_title' => 'general',
            'site_tagline' => 'general',
            'top_announcement_enabled' => 'general',
            'top_announcement_badge' => 'general',
            'top_announcement_icon' => 'general',
            'top_announcement_text' => 'general',
            'top_announcement_link' => 'general',
            'top_announcement_link_text' => 'general',
            'top_announcement_link_icon' => 'general',
            'top_announcement_bg_style' => 'general',

            // Hero & CTA Banners
            'hero_badge_text' => 'banner',
            'hero_title' => 'banner',
            'hero_highlight_text' => 'banner',
            'hero_description' => 'banner',
            'hero_btn1_text' => 'banner',
            'hero_btn1_url' => 'banner',
            'hero_btn2_text' => 'banner',
            'hero_btn2_url' => 'banner',
            'hero_apps_strip_enabled' => 'banner',
            'cta_banner_enabled' => 'banner',
            'cta_banner_title' => 'banner',
            'cta_banner_description' => 'banner',
            'cta_banner_btn1_text' => 'banner',
            'cta_banner_btn1_url' => 'banner',
            'cta_banner_btn2_text' => 'banner',
            'cta_banner_btn2_url' => 'banner',

            // Contact & Support
            'contact_address' => 'contact',
            'contact_phone' => 'contact',
            'contact_phone_raw' => 'contact',
            'contact_email' => 'contact',
            'whatsapp_number' => 'contact',
            'whatsapp_raw_number' => 'contact',
            'whatsapp_chat_message' => 'contact',
            'support_status_badge' => 'contact',
            'support_hours' => 'contact',

            // Social
            'social_whatsapp' => 'social',
            'social_facebook' => 'social',
            'social_linkedin' => 'social',
            'social_twitter' => 'social',
            'social_youtube' => 'social',
            'social_instagram' => 'social',

            // Footer
            'footer_about_text' => 'footer',
            'footer_copyright_text' => 'footer',
            'footer_disclaimer_text' => 'footer',
            'accepted_payment_methods_text' => 'footer',
            'floating_whatsapp_enabled' => 'footer',
            'floating_whatsapp_button_text' => 'footer',

            // SEO & Webmaster
            'meta_title' => 'seo',
            'meta_description' => 'seo',
            'meta_keywords' => 'seo',
            'meta_author' => 'seo',
            'og_title' => 'seo',
            'og_description' => 'seo',
            'twitter_card' => 'seo',
            'google_analytics_id' => 'seo',
            'custom_head_scripts' => 'seo',
            'custom_footer_scripts' => 'seo',
        ];

        // Handle Checkbox / Boolean defaults if form submitted for specific tabs
        if ($request->has('settings_form_submitted')) {
            $submittedGroup = $request->input('settings_form_submitted');

            if ($submittedGroup === 'general' || $submittedGroup === 'all') {
                SiteSetting::set('top_announcement_enabled', $request->has('top_announcement_enabled') ? '1' : '0', 'general');
            }

            if ($submittedGroup === 'banner' || $submittedGroup === 'all') {
                SiteSetting::set('hero_apps_strip_enabled', $request->has('hero_apps_strip_enabled') ? '1' : '0', 'banner');
                SiteSetting::set('cta_banner_enabled', $request->has('cta_banner_enabled') ? '1' : '0', 'banner');
            }

            if ($submittedGroup === 'footer' || $submittedGroup === 'all') {
                SiteSetting::set('floating_whatsapp_enabled', $request->has('floating_whatsapp_enabled') ? '1' : '0', 'footer');
            }
        }

        foreach ($fields as $key => $defaultGroup) {
            if ($request->has($key)) {
                $val = $request->input($key);
                SiteSetting::set($key, $val, $defaultGroup);
            }
        }

        // Handle navbar_menu_items
        if ($request->has('navbar_items')) {
            $rawNavbar = $request->input('navbar_items', []);
            $cleanNavbar = [];
            if (is_array($rawNavbar)) {
                $orderIdx = 1;
                foreach ($rawNavbar as $item) {
                    if (!empty($item['label']) && !empty($item['url'])) {
                        $cleanNavbar[] = [
                            'label' => trim($item['label']),
                            'url' => trim($item['url']),
                            'order' => isset($item['order']) && is_numeric($item['order']) ? (int)$item['order'] : $orderIdx,
                            'target' => in_array($item['target'] ?? '_self', ['_self', '_blank']) ? $item['target'] : '_self',
                            'enabled' => !empty($item['enabled']) && in_array($item['enabled'], ['1', 1, 'on', true], true) ? '1' : '0',
                        ];
                        $orderIdx++;
                    }
                }
                // Sort by order ascending
                usort($cleanNavbar, function ($a, $b) {
                    return ((int)($a['order'] ?? 0)) <=> ((int)($b['order'] ?? 0));
                });
                SiteSetting::set('navbar_menu_items', json_encode(array_values($cleanNavbar)), 'general');
            }
        }

        SiteSetting::clearCache();

        return redirect()->route('admin.site-settings.index', ['tab' => $request->input('active_tab', $group)])
            ->with('success', 'Site & System settings updated successfully!');
    }
}
