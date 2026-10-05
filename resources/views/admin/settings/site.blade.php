@extends('layouts.admin.admin')

@section('title', 'Site & Footer Settings | Admin Dashboard')

@section('content')
<div class="space-y-6 pb-12">
    <!-- Page Header & Quick Navigation -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400 mb-1">
                <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0067b8] transition-colors">Admin</a>
                <span>/</span>
                <span class="text-slate-700 dark:text-slate-300">Settings</span>
                <span>/</span>
                <span class="text-[#0067b8] font-bold">Site & Footer Customizer</span>
            </div>
            <h1 class="text-2xl font-black tracking-tight text-slate-900 dark:text-white flex items-center gap-2.5">
                <span class="w-2.5 h-7 rounded-full bg-[#0067b8]"></span>
                <span>Site, Footer & SEO Settings</span>
            </h1>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Customize brand logos, contact info, footer content, social links, and SEO meta tags across the website.
            </p>
        </div>

        <div class="flex items-center gap-2.5">
            <a href="{{ url('/') }}" target="_blank" class="inline-flex items-center gap-1.5 px-3.5 py-2 text-xs font-semibold rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-all shadow-2xs">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#0067b8]"></i>
                <span>View Website</span>
            </a>
            <button form="settings-form" type="submit" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005da6] text-white text-xs font-bold shadow-md shadow-[#0067b8]/25 transition-all">
                <i class="fa-solid fa-floppy-disk text-xs"></i>
                <span>Save All Changes</span>
            </button>
        </div>
    </div>

    <!-- Main Settings Form Container -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">

        <!-- Tab Navigation Bar -->
        <div class="border-b border-slate-200/90 dark:border-slate-800 bg-slate-50/70 dark:bg-slate-900/70 px-4 sm:px-6 pt-3 flex flex-wrap gap-1">
            <button type="button" onclick="switchSettingsTab('general')" id="tab-btn-general" class="settings-tab-btn flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all border-b-2 border-[#0067b8] text-[#0067b8] bg-white dark:bg-slate-900 shadow-xs">
                <i class="fa-solid fa-sliders text-sm"></i>
                <span>General & Branding</span>
            </button>

            <button type="button" onclick="switchSettingsTab('navbar')" id="tab-btn-navbar" class="settings-tab-btn flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all border-b-2 border-transparent text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">
                <i class="fa-solid fa-bars-staggered text-sm"></i>
                <span>Navbar & Menu</span>
            </button>

            <button type="button" onclick="switchSettingsTab('banner')" id="tab-btn-banner" class="settings-tab-btn flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all border-b-2 border-transparent text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">
                <i class="fa-solid fa-rectangle-ad text-sm"></i>
                <span>Hero & Banners</span>
            </button>

            <button type="button" onclick="switchSettingsTab('footer')" id="tab-btn-footer" class="settings-tab-btn flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all border-b-2 border-transparent text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">
                <i class="fa-solid fa-shoe-prints text-sm"></i>
                <span>Footer Customizer</span>
            </button>

            <button type="button" onclick="switchSettingsTab('contact')" id="tab-btn-contact" class="settings-tab-btn flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all border-b-2 border-transparent text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">
                <i class="fa-solid fa-headset text-sm"></i>
                <span>Contact & Support</span>
            </button>

            <button type="button" onclick="switchSettingsTab('social')" id="tab-btn-social" class="settings-tab-btn flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all border-b-2 border-transparent text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">
                <i class="fa-solid fa-share-nodes text-sm"></i>
                <span>Social Profiles</span>
            </button>

            <button type="button" onclick="switchSettingsTab('seo')" id="tab-btn-seo" class="settings-tab-btn flex items-center gap-2 px-4 py-3 text-xs font-bold rounded-t-xl transition-all border-b-2 border-transparent text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white">
                <i class="fa-solid fa-magnifying-glass-chart text-sm"></i>
                <span>SEO & Scripts</span>
            </button>
        </div>

        <!-- Form Body -->
        <form id="settings-form" action="{{ route('admin.site-settings.update') }}" method="POST" enctype="multipart/form-data" class="p-6 sm:p-8">
            @csrf
            <input type="hidden" name="active_tab" id="active_tab_input" value="{{ $activeTab }}">
            <input type="hidden" name="settings_form_submitted" id="settings_form_submitted" value="all">

            <!-- ====================================================================== -->
            <!-- TAB 1: GENERAL & BRANDING                                              -->
            <!-- ====================================================================== -->
            <div id="tab-content-general" class="settings-tab-pane space-y-8">
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-palette text-[#0067b8]"></i>
                        <span>Branding & Identity</span>
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Upload brand logos, favicon, and basic site title configurations.</p>
                </div>

                <!-- Logos & Favicon Upload Row -->
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">

                    <!-- Header Logo Card -->
                    <div class="p-5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40 flex flex-col justify-between space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                Header Logo (Navbar)
                            </label>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mb-3">Recommended: PNG / SVG with transparent background (Max 4MB).</p>

                            <div class="h-20 w-full rounded-xl bg-white dark:bg-slate-900 border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center p-2 relative overflow-hidden group">
                                <img id="preview_header_logo" src="{{ site_file_url('header_logo', 'assets/img/Microsoft Office Club Logo.png') }}" alt="Header Logo Preview" class="max-h-16 max-w-full object-contain">
                            </div>
                        </div>

                        <div>
                            <input type="file" name="header_logo" id="header_logo" accept="image/*" onchange="previewImage(this, 'preview_header_logo')" class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0067b8] file:text-white hover:file:bg-[#005da6] file:cursor-pointer cursor-pointer">
                        </div>
                    </div>

                    <!-- Footer Logo Card -->
                    <div class="p-5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40 flex flex-col justify-between space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                Footer Logo
                            </label>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mb-3">Logo displayed in the footer section. (PNG/SVG recommended).</p>

                            <div class="h-20 w-full rounded-xl bg-white dark:bg-slate-900 border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center p-2 relative overflow-hidden group">
                                <img id="preview_footer_logo" src="{{ site_file_url('footer_logo', 'assets/img/Microsoft Office Club Logo.png') }}" alt="Footer Logo Preview" class="max-h-16 max-w-full object-contain">
                            </div>
                        </div>

                        <div>
                            <input type="file" name="footer_logo" id="footer_logo" accept="image/*" onchange="previewImage(this, 'preview_footer_logo')" class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0067b8] file:text-white hover:file:bg-[#005da6] file:cursor-pointer cursor-pointer">
                        </div>
                    </div>

                    <!-- Favicon Card -->
                    <div class="p-5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40 flex flex-col justify-between space-y-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                Browser Favicon
                            </label>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400 mb-3">Square icon (32x32 or 64x64) in .ico, .png, or .svg format.</p>

                            <div class="h-20 w-full rounded-xl bg-white dark:bg-slate-900 border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center p-2 relative overflow-hidden group">
                                <img id="preview_favicon" src="{{ site_file_url('favicon', 'assets/img/favicon.png') }}" alt="Favicon Preview" class="w-10 h-10 object-contain">
                            </div>
                        </div>

                        <div>
                            <input type="file" name="favicon" id="favicon" accept="image/*,.ico" onchange="previewImage(this, 'preview_favicon')" class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0067b8] file:text-white hover:file:bg-[#005da6] file:cursor-pointer cursor-pointer">
                        </div>
                    </div>

                </div>

                <hr class="border-slate-200/80 dark:border-slate-800">

                <!-- Site Title & Basic Info -->
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="site_name" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            Site Name / Brand Name
                        </label>
                        <input type="text" name="site_name" id="site_name" value="{{ old('site_name', $settings['site_name'] ?? 'Microsoft Office Club') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Used in email templates, notifications, and brand mentions.</p>
                    </div>

                    <div>
                        <label for="site_title" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            Default Browser Window Title
                        </label>
                        <input type="text" name="site_title" id="site_title" value="{{ old('site_title', $settings['site_title'] ?? 'Microsoft Office Club | Official Subscriptions & Cloud Licensing Bangladesh') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Shown in the browser tab when no custom page title is specified.</p>
                    </div>

                    <div class="md:col-span-2">
                        <label for="site_tagline" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            Site Tagline / Headline
                        </label>
                        <input type="text" name="site_tagline" id="site_tagline" value="{{ old('site_tagline', $settings['site_tagline'] ?? 'Authorized Microsoft 365 cloud subscription provider in Bangladesh.') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    </div>
                </div>

                <hr class="border-slate-200/80 dark:border-slate-800">

                <!-- Top Announcement Ribbon (Top Bar) -->
                <div class="space-y-4 bg-slate-50/50 dark:bg-slate-950/40 p-5 rounded-2xl border border-slate-200 dark:border-slate-800">
                    <div class="flex items-center justify-between border-b border-slate-200/80 dark:border-slate-800 pb-3">
                        <div>
                            <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-emerald-500"></span>
                                <span>Navbar Top Bar (Announcement Ribbon)</span>
                            </h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">The persistent thin notification & hotline bar displayed directly above the header navbar.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="top_announcement_enabled" value="1" {{ ($settings['top_announcement_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-10 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-slate-600 peer-checked:bg-[#0067b8]"></div>
                            <span class="ml-2.5 text-xs font-semibold text-slate-700 dark:text-slate-300">Enable Top Bar</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label for="top_announcement_bg_style" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1">
                                Top Bar Color Theme
                            </label>
                            <select name="top_announcement_bg_style" id="top_announcement_bg_style" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none transition-all">
                                <option value="navy" {{ ($settings['top_announcement_bg_style'] ?? 'navy') === 'navy' ? 'selected' : '' }}>Microsoft Dark Navy Gradient (Default)</option>
                                <option value="blue" {{ ($settings['top_announcement_bg_style'] ?? '') === 'blue' ? 'selected' : '' }}>Fluent Blue Gradient</option>
                                <option value="emerald" {{ ($settings['top_announcement_bg_style'] ?? '') === 'emerald' ? 'selected' : '' }}>Emerald Dark Gradient</option>
                                <option value="dark" {{ ($settings['top_announcement_bg_style'] ?? '') === 'dark' ? 'selected' : '' }}>Deep Slate Black</option>
                            </select>
                        </div>

                        <div>
                            <label for="top_announcement_icon" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1">
                                Left Icon Type
                            </label>
                            <select name="top_announcement_icon" id="top_announcement_icon" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none transition-all">
                                <option value="microsoft_squares" {{ ($settings['top_announcement_icon'] ?? 'microsoft_squares') === 'microsoft_squares' ? 'selected' : '' }}>Microsoft 4-Color Squares (Default)</option>
                                <option value="fa-solid fa-bullhorn" {{ ($settings['top_announcement_icon'] ?? '') === 'fa-solid fa-bullhorn' ? 'selected' : '' }}>Bullhorn / Megaphone</option>
                                <option value="fa-solid fa-bolt" {{ ($settings['top_announcement_icon'] ?? '') === 'fa-solid fa-bolt' ? 'selected' : '' }}>Lightning Bolt</option>
                                <option value="fa-solid fa-shield-halved" {{ ($settings['top_announcement_icon'] ?? '') === 'fa-solid fa-shield-halved' ? 'selected' : '' }}>Verified Shield</option>
                                <option value="none" {{ ($settings['top_announcement_icon'] ?? '') === 'none' ? 'selected' : '' }}>No Icon</option>
                            </select>
                        </div>

                        <div>
                            <label for="top_announcement_badge" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1">
                                Left Bold Badge Title
                            </label>
                            <input type="text" name="top_announcement_badge" id="top_announcement_badge" value="{{ old('top_announcement_badge', $settings['top_announcement_badge'] ?? 'Official Microsoft Reseller') }}" placeholder="e.g. Official Microsoft Reseller" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none transition-all">
                        </div>

                        <div class="md:col-span-3">
                            <label for="top_announcement_text" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1">
                                Main Announcement / Offer Notice Text
                            </label>
                            <input type="text" name="top_announcement_text" id="top_announcement_text" value="{{ old('top_announcement_text', $settings['top_announcement_text'] ?? 'Purchase plan via bKash, Nagad & Cards') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none transition-all">
                        </div>

                        <div>
                            <label for="top_announcement_link_icon" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1">
                                Right Action Icon
                            </label>
                            <select name="top_announcement_link_icon" id="top_announcement_link_icon" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none transition-all">
                                <option value="fa-brands fa-whatsapp" {{ ($settings['top_announcement_link_icon'] ?? 'fa-brands fa-whatsapp') === 'fa-brands fa-whatsapp' ? 'selected' : '' }}>WhatsApp Icon (Green)</option>
                                <option value="fa-solid fa-phone" {{ ($settings['top_announcement_link_icon'] ?? '') === 'fa-solid fa-phone' ? 'selected' : '' }}>Phone Icon</option>
                                <option value="fa-solid fa-envelope" {{ ($settings['top_announcement_link_icon'] ?? '') === 'fa-solid fa-envelope' ? 'selected' : '' }}>Envelope Icon</option>
                                <option value="fa-solid fa-arrow-right" {{ ($settings['top_announcement_link_icon'] ?? '') === 'fa-solid fa-arrow-right' ? 'selected' : '' }}>Arrow Right Icon</option>
                                <option value="" {{ ($settings['top_announcement_link_icon'] ?? '') === '' ? 'selected' : '' }}>No Icon</option>
                            </select>
                        </div>

                        <div>
                            <label for="top_announcement_link_text" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1">
                                Right Action Button Text
                            </label>
                            <input type="text" name="top_announcement_link_text" id="top_announcement_link_text" value="{{ old('top_announcement_link_text', $settings['top_announcement_link_text'] ?? 'WhatsApp Helpline: +880 1342-325558') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none transition-all">
                        </div>

                        <div>
                            <label for="top_announcement_link" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1">
                                Right Action Target URL
                            </label>
                            <input type="text" name="top_announcement_link" id="top_announcement_link" value="{{ old('top_announcement_link', $settings['top_announcement_link'] ?? 'https://wa.me/8801342325558') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none transition-all">
                        </div>
                    </div>
                </div>
            </div>


            <!-- ====================================================================== -->
            <!-- TAB 2: NAVBAR & MENU CUSTOMIZER                                        -->
            <!-- ====================================================================== -->
            <div id="tab-content-navbar" class="settings-tab-pane hidden space-y-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3">
                    <div>
                        <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                            <i class="fa-solid fa-bars-staggered text-[#0067b8]"></i>
                            <span>Storefront Navbar & Menu Items Customizer</span>
                        </h3>
                        <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Customize website navigation links, reorder menu items, set anchor targets, or add custom page links.</p>
                    </div>
                    <button type="button" onclick="addNavbarRow()" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-sky-50 dark:bg-sky-950/60 hover:bg-sky-100 text-[#0067b8] dark:text-sky-400 font-bold text-xs border border-sky-200 dark:border-sky-800 transition-all cursor-pointer">
                        <i class="fa-solid fa-plus text-xs"></i>
                        <span>Add Menu Link</span>
                    </button>
                </div>

                @php
                    $rawAdminNav = $settings['navbar_menu_items'] ?? '';
                    $adminNavItems = [];
                    if (!empty($rawAdminNav)) {
                        $decoded = is_array($rawAdminNav) ? $rawAdminNav : json_decode($rawAdminNav, true);
                        if (is_array($decoded)) {
                            $adminNavItems = $decoded;
                        }
                    }
                    if (empty($adminNavItems)) {
                        $adminNavItems = [
                            ['label' => 'Key Features', 'url' => '#key-features', 'enabled' => '1', 'target' => '_self'],
                            ['label' => 'Included Apps', 'url' => '#included-apps', 'enabled' => '1', 'target' => '_self'],
                            ['label' => 'Plans & Pricing', 'url' => '#plans', 'enabled' => '1', 'target' => '_self'],
                            ['label' => 'AI Features', 'url' => '#ai-features', 'enabled' => '1', 'target' => '_self'],
                            ['label' => 'How It Works', 'url' => '#how-it-works', 'enabled' => '1', 'target' => '_self'],
                            ['label' => 'FAQ', 'url' => '#faq', 'enabled' => '1', 'target' => '_self'],
                            ['label' => 'Contact', 'url' => '#contact-support', 'enabled' => '1', 'target' => '_self'],
                        ];
                    }
                @endphp

                <!-- Navbar Links Table -->
                <div class="bg-slate-50/50 dark:bg-slate-950/40 p-5 sm:p-6 rounded-2xl border border-slate-200 dark:border-slate-800 space-y-4">
                    <div class="overflow-x-auto">
                        <table class="w-full text-left text-xs text-slate-600 dark:text-slate-300">
                            <thead>
                                <tr class="border-b border-slate-200 dark:border-slate-800 text-[11px] font-extrabold uppercase text-slate-400">
                                    <th class="py-3 px-3">Status</th>
                                    <th class="py-3 px-3">Menu Label Text</th>
                                    <th class="py-3 px-3">Target Anchor / URL</th>
                                    <th class="py-3 px-3">Target</th>
                                    <th class="py-3 px-3 text-right">Action</th>
                                </tr>
                            </thead>
                            <tbody id="navbar-items-tbody" class="divide-y divide-slate-200 dark:divide-slate-800">
                                @foreach($adminNavItems as $index => $nav)
                                <tr class="nav-item-row group hover:bg-white dark:hover:bg-slate-900/60 transition-colors" data-index="{{ $index }}">
                                    <!-- Enabled Toggle -->
                                    <td class="py-3 px-3 align-middle w-24">
                                        <label class="relative inline-flex items-center cursor-pointer">
                                            <input type="checkbox" name="navbar_items[{{ $index }}][enabled]" value="1" {{ (!isset($nav['enabled']) || $nav['enabled'] == '1' || $nav['enabled'] === true) ? 'checked' : '' }} class="sr-only peer">
                                            <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                                        </label>
                                    </td>

                                    <!-- Label Input -->
                                    <td class="py-3 px-3 align-middle">
                                        <input type="text" name="navbar_items[{{ $index }}][label]" value="{{ $nav['label'] ?? '' }}" placeholder="e.g. Plans & Pricing" required class="w-full px-3 py-2 text-xs font-bold rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none">
                                    </td>

                                    <!-- URL / Anchor Input with presets -->
                                    <td class="py-3 px-3 align-middle">
                                        <div class="flex items-center gap-2">
                                            <input type="text" name="navbar_items[{{ $index }}][url]" value="{{ $nav['url'] ?? '' }}" placeholder="e.g. #plans or /login" required class="nav-url-input flex-1 px-3 py-2 text-xs font-mono rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none">
                                            <select onchange="applyPresetToRow(this)" class="px-2.5 py-2 text-[11px] rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 focus:ring-2 focus:ring-[#0067b8] outline-none">
                                                <option value="">-- Presets --</option>
                                                <option value="#key-features" {{ ($nav['url'] ?? '') === '#key-features' ? 'selected' : '' }}>#key-features</option>
                                                <option value="#included-apps" {{ ($nav['url'] ?? '') === '#included-apps' ? 'selected' : '' }}>#included-apps</option>
                                                <option value="#plans" {{ ($nav['url'] ?? '') === '#plans' ? 'selected' : '' }}>#plans</option>
                                                <option value="#ai-features" {{ ($nav['url'] ?? '') === '#ai-features' ? 'selected' : '' }}>#ai-features</option>
                                                <option value="#how-it-works" {{ ($nav['url'] ?? '') === '#how-it-works' ? 'selected' : '' }}>#how-it-works</option>
                                                <option value="#faq" {{ ($nav['url'] ?? '') === '#faq' ? 'selected' : '' }}>#faq</option>
                                                <option value="#contact-support" {{ ($nav['url'] ?? '') === '#contact-support' ? 'selected' : '' }}>#contact-support</option>
                                            </select>
                                        </div>
                                    </td>

                                    <!-- Target -->
                                    <td class="py-3 px-3 align-middle w-32">
                                        <select name="navbar_items[{{ $index }}][target]" class="w-full px-2.5 py-2 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none">
                                            <option value="_self" {{ ($nav['target'] ?? '_self') === '_self' ? 'selected' : '' }}>Same Tab (_self)</option>
                                            <option value="_blank" {{ ($nav['target'] ?? '') === '_blank' ? 'selected' : '' }}>New Tab (_blank)</option>
                                        </select>
                                    </td>

                                    <!-- Action -->
                                    <td class="py-3 px-3 align-middle text-right w-20">
                                        <button type="button" onclick="removeNavbarRow(this)" class="w-8 h-8 rounded-xl bg-red-50 dark:bg-red-950/60 hover:bg-red-100 dark:hover:bg-red-900/80 text-red-600 dark:text-red-400 flex items-center justify-center transition-colors ml-auto" title="Remove Link">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    <div class="flex flex-wrap items-center justify-between gap-3 pt-3 border-t border-slate-200 dark:border-slate-800">
                        <p class="text-[11px] text-slate-400">
                            <i class="fa-solid fa-circle-info mr-1 text-[#0067b8]"></i>
                            Tip: Target anchors like <code>#plans</code> scroll smoothly to sections on the homepage.
                        </p>
                        <button type="button" onclick="resetNavbarDefaults()" class="text-xs font-bold text-slate-500 hover:text-slate-800 dark:hover:text-white transition-colors cursor-pointer">
                            <i class="fa-solid fa-rotate-left mr-1"></i> Reset to Default Sections
                        </button>
                    </div>
                </div>
            </div>


            <!-- ====================================================================== -->
            <!-- TAB: HERO & CTA BANNERS CUSTOMIZER                                     -->
            <!-- ====================================================================== -->
            <div id="tab-content-banner" class="settings-tab-pane hidden space-y-8">
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-rectangle-ad text-[#0067b8]"></i>
                        <span>Hero Banner & CTA Banners Customizer</span>
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Control the main hero banner headline, highlight text, description, action buttons, visual mockups, and secondary CTA ribbon.</p>
                </div>

                <!-- 1. Main Hero Banner Settings -->
                <div class="space-y-6 bg-slate-50/50 dark:bg-slate-950/40 p-5 sm:p-6 rounded-2xl border border-slate-200 dark:border-slate-800">
                    <div class="flex items-center justify-between border-b border-slate-200/80 dark:border-slate-800 pb-3">
                        <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-[#0067b8]"></span>
                            <span>Top Main Hero Banner</span>
                        </h4>
                        <span class="text-[11px] font-semibold text-slate-500 dark:text-slate-400">Homepage Primary Section</span>
                    </div>

                    <!-- Images Upload Row -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                        <!-- Hero Banner Mockup Graphic -->
                        <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 flex flex-col justify-between space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-0.5">
                                    Hero Graphic / Laptop Mockup Image
                                </label>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mb-2">Recommended: PNG / WebP with transparent background (Max 4MB).</p>

                                <div class="h-32 w-full rounded-lg bg-slate-50 dark:bg-slate-950 border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center p-2 relative overflow-hidden group">
                                    <img id="preview_hero_banner_image" src="{{ site_file_url('hero_banner_image', 'assets/img/banner.png') }}" alt="Hero Banner Preview" class="max-h-28 max-w-full object-contain">
                                </div>
                            </div>

                            <div>
                                <input type="file" name="hero_banner_image" id="hero_banner_image" accept="image/*" onchange="previewImage(this, 'preview_hero_banner_image')" class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0067b8] file:text-white hover:file:bg-[#005da6] file:cursor-pointer cursor-pointer">
                            </div>
                        </div>

                        <!-- Hero Background Graphic -->
                        <div class="p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 flex flex-col justify-between space-y-3">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-0.5">
                                    Hero Ambient Background Pattern
                                </label>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mb-2">Subtle ambient backdrop layer (Default: bg.png).</p>

                                <div class="h-32 w-full rounded-lg bg-slate-50 dark:bg-slate-950 border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center p-2 relative overflow-hidden group">
                                    <img id="preview_hero_bg_image" src="{{ site_file_url('hero_bg_image', 'assets/img/bg.png') }}" alt="Hero BG Preview" class="max-h-28 max-w-full object-cover">
                                </div>
                            </div>

                            <div>
                                <input type="file" name="hero_bg_image" id="hero_bg_image" accept="image/*" onchange="previewImage(this, 'preview_hero_bg_image')" class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0067b8] file:text-white hover:file:bg-[#005da6] file:cursor-pointer cursor-pointer">
                            </div>
                        </div>

                    </div>

                    <!-- Textual Content Inputs -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div>
                            <label for="hero_badge_text" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                Kicker / Tagline Badge Text
                            </label>
                            <input type="text" name="hero_badge_text" id="hero_badge_text" value="{{ old('hero_badge_text', $settings['hero_badge_text'] ?? 'WORK SMARTER. TOGETHER.') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        </div>

                        <div>
                            <label for="hero_highlight_text" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                Highlighted Phrase (In Brand Blue Accent)
                            </label>
                            <input type="text" name="hero_highlight_text" id="hero_highlight_text" value="{{ old('hero_highlight_text', $settings['hero_highlight_text'] ?? 'a more connected world') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                            <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">This specific phrase inside the title will be rendered with special blue accent highlight.</p>
                        </div>

                        <div class="md:col-span-2">
                            <label for="hero_title" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                Hero Main Headline
                            </label>
                            <input type="text" name="hero_title" id="hero_title" value="{{ old('hero_title', $settings['hero_title'] ?? 'The all-in-one productivity platform for a more connected world') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        </div>

                        <div class="md:col-span-2">
                            <label for="hero_description" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                Hero Subtitle / Descriptive Summary
                            </label>
                            <textarea name="hero_description" id="hero_description" rows="3" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">{{ old('hero_description', $settings['hero_description'] ?? 'Microsoft 365 brings together your favorite apps, AI-powered tools, cloud storage, and advanced security — all in one place, so you can create, collaborate, and get more done from anywhere.') }}</textarea>
                        </div>

                        <!-- CTA Button 1 -->
                        <div class="p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 space-y-3">
                            <h5 class="text-xs font-bold text-[#0067b8] uppercase tracking-wider">Primary Action Button</h5>
                            <div>
                                <label for="hero_btn1_text" class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">Button Label</label>
                                <input type="text" name="hero_btn1_text" id="hero_btn1_text" value="{{ old('hero_btn1_text', $settings['hero_btn1_text'] ?? 'Get Microsoft 365') }}" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none">
                            </div>
                            <div>
                                <label for="hero_btn1_url" class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">Target URL / Anchor</label>
                                <input type="text" name="hero_btn1_url" id="hero_btn1_url" value="{{ old('hero_btn1_url', $settings['hero_btn1_url'] ?? '#plans') }}" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none">
                            </div>
                        </div>

                        <!-- CTA Button 2 -->
                        <div class="p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 space-y-3">
                            <h5 class="text-xs font-bold text-slate-700 dark:text-slate-300 uppercase tracking-wider">Secondary Action Button</h5>
                            <div>
                                <label for="hero_btn2_text" class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">Button Label</label>
                                <input type="text" name="hero_btn2_text" id="hero_btn2_text" value="{{ old('hero_btn2_text', $settings['hero_btn2_text'] ?? 'See plans and pricing') }}" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none">
                            </div>
                            <div>
                                <label for="hero_btn2_url" class="block text-[11px] font-semibold text-slate-700 dark:text-slate-300 mb-1">Target URL / Anchor</label>
                                <input type="text" name="hero_btn2_url" id="hero_btn2_url" value="{{ old('hero_btn2_url', $settings['hero_btn2_url'] ?? '#plans') }}" class="w-full px-3 py-2 text-xs rounded-lg border border-slate-300 dark:border-slate-700 bg-slate-50 dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none">
                            </div>
                        </div>

                        <!-- Apps strip toggle -->
                        <div class="md:col-span-2 flex items-center justify-between p-3.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900">
                            <div>
                                <h5 class="text-xs font-bold text-slate-800 dark:text-slate-200">Floating Microsoft Apps Strip</h5>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400">Display the 13 interactive Microsoft App icons bar at the bottom of the hero banner.</p>
                            </div>
                            <label class="relative inline-flex items-center cursor-pointer">
                                <input type="checkbox" name="hero_apps_strip_enabled" value="1" {{ ($settings['hero_apps_strip_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                                <div class="w-10 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-slate-600 peer-checked:bg-[#0067b8]"></div>
                            </label>
                        </div>

                    </div>
                </div>

                <hr class="border-slate-200/80 dark:border-slate-800">

                <!-- 2. CTA Ribbon Banner Settings (Ready to get started) -->
                <div class="space-y-6 bg-slate-50/50 dark:bg-slate-950/40 p-5 sm:p-6 rounded-2xl border border-slate-200 dark:border-slate-800">
                    <div class="flex items-center justify-between border-b border-slate-200/80 dark:border-slate-800 pb-3">
                        <div>
                            <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-800 dark:text-slate-200 flex items-center gap-2">
                                <span class="w-2 h-2 rounded-full bg-purple-500"></span>
                                <span>Secondary CTA Banner ("Ready to get started")</span>
                            </h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">The aurora ribbon wave banner section right before the FAQ section.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="cta_banner_enabled" value="1" {{ ($settings['cta_banner_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-10 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-slate-600 peer-checked:bg-[#0067b8]"></div>
                            <span class="ml-2.5 text-xs font-semibold text-slate-700 dark:text-slate-300">Enable Banner</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">

                        <div class="md:col-span-2">
                            <label for="cta_banner_title" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                CTA Banner Headline
                            </label>
                            <input type="text" name="cta_banner_title" id="cta_banner_title" value="{{ old('cta_banner_title', $settings['cta_banner_title'] ?? 'Ready to get started with Microsoft 365?') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        </div>

                        <div class="md:col-span-2">
                            <label for="cta_banner_description" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                CTA Banner Subtitle
                            </label>
                            <input type="text" name="cta_banner_description" id="cta_banner_description" value="{{ old('cta_banner_description', $settings['cta_banner_description'] ?? 'Join millions of people and organizations who are doing more with Microsoft 365.') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        </div>

                        <div>
                            <label for="cta_banner_btn1_text" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                CTA Primary Button Text
                            </label>
                            <input type="text" name="cta_banner_btn1_text" id="cta_banner_btn1_text" value="{{ old('cta_banner_btn1_text', $settings['cta_banner_btn1_text'] ?? 'Get Microsoft 365') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        </div>

                        <div>
                            <label for="cta_banner_btn1_url" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                CTA Primary Button Link
                            </label>
                            <input type="text" name="cta_banner_btn1_url" id="cta_banner_btn1_url" value="{{ old('cta_banner_btn1_url', $settings['cta_banner_btn1_url'] ?? '#plans') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        </div>

                        <div>
                            <label for="cta_banner_btn2_text" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                CTA Secondary Button Text
                            </label>
                            <input type="text" name="cta_banner_btn2_text" id="cta_banner_btn2_text" value="{{ old('cta_banner_btn2_text', $settings['cta_banner_btn2_text'] ?? 'Compare plans') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        </div>

                        <div>
                            <label for="cta_banner_btn2_url" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                CTA Secondary Button Link
                            </label>
                            <input type="text" name="cta_banner_btn2_url" id="cta_banner_btn2_url" value="{{ old('cta_banner_btn2_url', $settings['cta_banner_btn2_url'] ?? '#plans') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        </div>

                        <!-- CTA Background Pattern Image -->
                        <div class="md:col-span-2 p-4 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-900 flex flex-col md:flex-row items-center justify-between gap-4">
                            <div class="flex items-center gap-4">
                                <div class="h-16 w-32 rounded-lg bg-slate-100 dark:bg-slate-950 border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center p-1 overflow-hidden">
                                    <img id="preview_cta_banner_bg_image" src="{{ site_file_url('cta_banner_bg_image', 'assets/img/Pastel Aurora Ribbon Waves.png') }}" alt="CTA Ribbon Preview" class="max-h-14 max-w-full object-cover">
                                </div>
                                <div>
                                    <label class="block text-xs font-bold text-slate-800 dark:text-slate-200">
                                        Aurora Ribbon Wave Background
                                    </label>
                                    <p class="text-[11px] text-slate-500 dark:text-slate-400">Right-aligned ambient wave image (Default: Pastel Aurora Ribbon Waves.png).</p>
                                </div>
                            </div>
                            <input type="file" name="cta_banner_bg_image" id="cta_banner_bg_image" accept="image/*" onchange="previewImage(this, 'preview_cta_banner_bg_image')" class="text-xs text-slate-500 dark:text-slate-400 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0067b8] file:text-white hover:file:bg-[#005da6] file:cursor-pointer cursor-pointer">
                        </div>

                    </div>
                </div>
            </div>


            <!-- ====================================================================== -->
            <!-- TAB 2: FOOTER CUSTOMIZER                                               -->
            <!-- ====================================================================== -->
            <div id="tab-content-footer" class="settings-tab-pane hidden space-y-8">
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-shoe-prints text-[#0067b8]"></i>
                        <span>Footer Layout & Content</span>
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Customize texts, copyright note, disclaimer notice, accepted payment badges, and floating support widget.</p>
                </div>

                <div class="space-y-6">
                    <div>
                        <label for="footer_about_text" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            Footer Company Bio / About Text
                        </label>
                        <textarea name="footer_about_text" id="footer_about_text" rows="3" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">{{ old('footer_about_text', $settings['footer_about_text'] ?? 'Authorized Microsoft 365 cloud subscription provider in Bangladesh. Genuine cloud licensing, automated activation, local BDT checkout with bKash & Nagad, and 24/7 dedicated support.') }}</textarea>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Appears under the footer logo on the left column.</p>
                    </div>

                    <div>
                        <label for="accepted_payment_methods_text" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            Accepted Payment Methods Display Text
                        </label>
                        <input type="text" name="accepted_payment_methods_text" id="accepted_payment_methods_text" value="{{ old('accepted_payment_methods_text', $settings['accepted_payment_methods_text'] ?? 'bKash (Personal & Merchant), Nagad, Visa / Mastercard / AMEX') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Comma-separated payment method names displayed as clean badges in footer.</p>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="footer_copyright_text" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                Bottom Copyright Notice
                            </label>
                            <input type="text" name="footer_copyright_text" id="footer_copyright_text" value="{{ old('footer_copyright_text', $settings['footer_copyright_text'] ?? '© 2026 Microsoft 365 Reseller Bangladesh. All rights reserved.') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        </div>

                        <div>
                            <label for="footer_disclaimer_text" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                Bottom Disclaimer & Trademark Notice
                            </label>
                            <textarea name="footer_disclaimer_text" id="footer_disclaimer_text" rows="2" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">{{ old('footer_disclaimer_text', $settings['footer_disclaimer_text'] ?? 'Microsoft, Microsoft 365, Office 365, Word, Excel, PowerPoint, Outlook, Teams, OneDrive, and Copilot are registered trademarks of Microsoft Corporation. We are an authorized cloud solution provider & reseller.') }}</textarea>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-200/80 dark:border-slate-800">

                <!-- Floating WhatsApp Widget Customizer -->
                <div class="space-y-4">
                    <div class="flex items-center justify-between">
                        <div>
                            <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider flex items-center gap-2">
                                <i class="fa-brands fa-whatsapp text-emerald-500 text-sm"></i>
                                <span>Floating WhatsApp Support Widget</span>
                            </h4>
                            <p class="text-[11px] text-slate-500 dark:text-slate-400">The persistent floating chat button located at the bottom-right corner of website pages.</p>
                        </div>
                        <label class="relative inline-flex items-center cursor-pointer">
                            <input type="checkbox" name="floating_whatsapp_enabled" value="1" {{ ($settings['floating_whatsapp_enabled'] ?? '1') == '1' ? 'checked' : '' }} class="sr-only peer">
                            <div class="w-10 h-5 bg-slate-300 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all dark:border-slate-600 peer-checked:bg-emerald-600"></div>
                            <span class="ml-2.5 text-xs font-semibold text-slate-700 dark:text-slate-300">Show Button</span>
                        </label>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="floating_whatsapp_button_text" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1">
                                Floating Button Label Text
                            </label>
                            <input type="text" name="floating_whatsapp_button_text" id="floating_whatsapp_button_text" value="{{ old('floating_whatsapp_button_text', $settings['floating_whatsapp_button_text'] ?? 'WhatsApp Support') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        </div>

                        <div>
                            <label for="whatsapp_chat_message" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1">
                                Pre-filled WhatsApp Chat Message
                            </label>
                            <input type="text" name="whatsapp_chat_message" id="whatsapp_chat_message" value="{{ old('whatsapp_chat_message', $settings['whatsapp_chat_message'] ?? 'Hello I want to order Microsoft 365 Subscription') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        </div>
                    </div>
                </div>
            </div>


            <!-- ====================================================================== -->
            <!-- TAB 3: CONTACT & SUPPORT                                               -->
            <!-- ====================================================================== -->
            <div id="tab-content-contact" class="settings-tab-pane hidden space-y-8">
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-headset text-[#0067b8]"></i>
                        <span>Contact, Phone, Address & Support</span>
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Manage the helpline numbers, physical address, support email, and 24/7 status badges shown in header, footer, and contact section.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="md:col-span-2">
                        <label for="contact_address" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            Office Address / Location
                        </label>
                        <input type="text" name="contact_address" id="contact_address" value="{{ old('contact_address', $settings['contact_address'] ?? 'Gulshan-2 / Motijheel, Dhaka, Bangladesh') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    </div>

                    <div>
                        <label for="contact_phone" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            Support Phone (Display text)
                        </label>
                        <input type="text" name="contact_phone" id="contact_phone" value="{{ old('contact_phone', $settings['contact_phone'] ?? '09649-0123756') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    </div>

                    <div>
                        <label for="contact_phone_raw" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            Support Phone (tel: clickable number)
                        </label>
                        <input type="text" name="contact_phone_raw" id="contact_phone_raw" value="{{ old('contact_phone_raw', $settings['contact_phone_raw'] ?? '+88096490123756') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">E.g. +88096490123756 (without spaces for tel: link).</p>
                    </div>

                    <div>
                        <label for="contact_email" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            Customer Support Email
                        </label>
                        <input type="email" name="contact_email" id="contact_email" value="{{ old('contact_email', $settings['contact_email'] ?? 'support@cloudsync.com.bd') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    </div>

                    <div>
                        <label for="whatsapp_number" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            WhatsApp Number (Display format)
                        </label>
                        <input type="text" name="whatsapp_number" id="whatsapp_number" value="{{ old('whatsapp_number', $settings['whatsapp_number'] ?? '+880 1342-325558') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    </div>

                    <div>
                        <label for="whatsapp_raw_number" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            WhatsApp Digits (for wa.me/ link)
                        </label>
                        <input type="text" name="whatsapp_raw_number" id="whatsapp_raw_number" value="{{ old('whatsapp_raw_number', $settings['whatsapp_raw_number'] ?? '8801342325558') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Country code + number without + or spaces (e.g. 8801342325558).</p>
                    </div>

                    <div>
                        <label for="support_status_badge" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            Support Status Badge Text
                        </label>
                        <input type="text" name="support_status_badge" id="support_status_badge" value="{{ old('support_status_badge', $settings['support_status_badge'] ?? "") }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    </div>

                    <div class="md:col-span-2">
                        <label for="support_hours" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            Support Hours & Availability Description
                        </label>
                        <input type="text" name="support_hours" id="support_hours" value="{{ old('support_hours', $settings['support_hours'] ?? '24/7 Mon-Sun Dedicated Cloud Support') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    </div>
                </div>
            </div>


            <!-- ====================================================================== -->
            <!-- TAB 4: SOCIAL PROFILES                                                 -->
            <!-- ====================================================================== -->
            <div id="tab-content-social" class="settings-tab-pane hidden space-y-8">
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-share-nodes text-[#0067b8]"></i>
                        <span>Social Media Channels</span>
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Links to your official business social media pages displayed on footer and contact touchpoints.</p>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label for="social_whatsapp" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5 flex items-center gap-2">
                            <i class="fa-brands fa-whatsapp text-emerald-500"></i>
                            <span>WhatsApp Link / Channel</span>
                        </label>
                        <input type="text" name="social_whatsapp" id="social_whatsapp" value="{{ old('social_whatsapp', $settings['social_whatsapp'] ?? 'https://wa.me/8801342325558') }}" placeholder="https://wa.me/..." class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    </div>

                    <div>
                        <label for="social_facebook" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5 flex items-center gap-2">
                            <i class="fa-brands fa-facebook text-[#1877f2]"></i>
                            <span>Facebook Page URL</span>
                        </label>
                        <input type="text" name="social_facebook" id="social_facebook" value="{{ old('social_facebook', $settings['social_facebook'] ?? 'https://facebook.com') }}" placeholder="https://facebook.com/yourpage" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    </div>

                    <div>
                        <label for="social_linkedin" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5 flex items-center gap-2">
                            <i class="fa-brands fa-linkedin text-[#0077b5]"></i>
                            <span>LinkedIn Page URL</span>
                        </label>
                        <input type="text" name="social_linkedin" id="social_linkedin" value="{{ old('social_linkedin', $settings['social_linkedin'] ?? 'https://linkedin.com') }}" placeholder="https://linkedin.com/company/..." class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    </div>

                    <div>
                        <label for="social_twitter" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5 flex items-center gap-2">
                            <i class="fa-brands fa-x-twitter text-slate-900 dark:text-white"></i>
                            <span>Twitter / X Profile URL</span>
                        </label>
                        <input type="text" name="social_twitter" id="social_twitter" value="{{ old('social_twitter', $settings['social_twitter'] ?? 'https://x.com') }}" placeholder="https://x.com/yourhandle" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    </div>

                    <div>
                        <label for="social_youtube" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5 flex items-center gap-2">
                            <i class="fa-brands fa-youtube text-red-600"></i>
                            <span>YouTube Channel URL</span>
                        </label>
                        <input type="text" name="social_youtube" id="social_youtube" value="{{ old('social_youtube', $settings['social_youtube'] ?? '') }}" placeholder="https://youtube.com/@channel" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    </div>

                    <div>
                        <label for="social_instagram" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5 flex items-center gap-2">
                            <i class="fa-brands fa-instagram text-pink-600"></i>
                            <span>Instagram Profile URL</span>
                        </label>
                        <input type="text" name="social_instagram" id="social_instagram" value="{{ old('social_instagram', $settings['social_instagram'] ?? '') }}" placeholder="https://instagram.com/profile" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    </div>
                </div>
            </div>


            <!-- ====================================================================== -->
            <!-- TAB 5: SEO & WEBMASTER SCRIPTS                                         -->
            <!-- ====================================================================== -->
            <div id="tab-content-seo" class="settings-tab-pane hidden space-y-8">
                <div>
                    <h3 class="text-base font-bold text-slate-900 dark:text-white flex items-center gap-2">
                        <i class="fa-solid fa-magnifying-glass-chart text-[#0067b8]"></i>
                        <span>Search Engine Optimization (SEO) & Tracking Scripts</span>
                    </h3>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Optimize search rankings, social preview cards (Open Graph), Google Analytics, and custom header/footer script tags.</p>
                </div>

                <!-- Meta Tags -->
                <div class="space-y-6">
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label for="meta_title" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                Meta Title
                            </label>
                            <input type="text" name="meta_title" id="meta_title" value="{{ old('meta_title', $settings['meta_title'] ?? 'Microsoft 365 Official Subscriptions Bangladesh | Genuine Cloud Licensing') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                            <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Recommended length: 50-60 characters.</p>
                        </div>

                        <div>
                            <label for="meta_author" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                Meta Author / Organization
                            </label>
                            <input type="text" name="meta_author" id="meta_author" value="{{ old('meta_author', $settings['meta_author'] ?? 'Microsoft Office Club Bangladesh') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        </div>
                    </div>

                    <div>
                        <label for="meta_description" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            Meta Description
                        </label>
                        <textarea name="meta_description" id="meta_description" rows="3" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">{{ old('meta_description', $settings['meta_description'] ?? 'Official Microsoft 365, Office Apps, and Copilot AI subscription reseller in Bangladesh. Instant BDT payment via bKash/Nagad, automated license provisioning, and 24/7 Dhaka support.') }}</textarea>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Recommended length: 150-160 characters.</p>
                    </div>

                    <div>
                        <label for="meta_keywords" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                            Meta Keywords (Comma separated)
                        </label>
                        <input type="text" name="meta_keywords" id="meta_keywords" value="{{ old('meta_keywords', $settings['meta_keywords'] ?? 'microsoft 365 bangladesh, buy office 365 dhaka, genuine microsoft license, bkash payment microsoft, copilot ai bangladesh') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    </div>
                </div>

                <hr class="border-slate-200/80 dark:border-slate-800">

                <!-- Open Graph (Facebook / Social Share) -->
                <div>
                    <h4 class="text-xs font-bold text-slate-800 dark:text-slate-200 uppercase tracking-wider mb-4">Open Graph (Social Share Card)</h4>

                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        <div class="md:col-span-2 space-y-4">
                            <div>
                                <label for="og_title" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                    OG Share Title
                                </label>
                                <input type="text" name="og_title" id="og_title" value="{{ old('og_title', $settings['og_title'] ?? 'Microsoft 365 Official Subscriptions Bangladesh') }}" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                            </div>

                            <div>
                                <label for="og_description" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                    OG Share Description
                                </label>
                                <textarea name="og_description" id="og_description" rows="2" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">{{ old('og_description', $settings['og_description'] ?? 'Get genuine Microsoft 365 cloud subscriptions with instant activation and local BDT payment.') }}</textarea>
                            </div>

                            <div>
                                <label for="twitter_card" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5">
                                    Twitter Card Format
                                </label>
                                <select name="twitter_card" id="twitter_card" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                                    <option value="summary_large_image" {{ ($settings['twitter_card'] ?? 'summary_large_image') === 'summary_large_image' ? 'selected' : '' }}>summary_large_image (Recommended)</option>
                                    <option value="summary" {{ ($settings['twitter_card'] ?? '') === 'summary' ? 'selected' : '' }}>summary (Small thumbnail)</option>
                                </select>
                            </div>
                        </div>

                        <!-- OG Image Card -->
                        <div class="p-5 rounded-2xl border border-slate-200 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-950/40 flex flex-col justify-between space-y-4">
                            <div>
                                <label class="block text-xs font-bold text-slate-800 dark:text-slate-200 mb-1">
                                    Social Share Preview Image
                                </label>
                                <p class="text-[11px] text-slate-500 dark:text-slate-400 mb-3">Recommended: 1200 x 630 px (JPEG/PNG).</p>

                                <div class="h-28 w-full rounded-xl bg-white dark:bg-slate-900 border border-dashed border-slate-300 dark:border-slate-700 flex items-center justify-center p-2 relative overflow-hidden group">
                                    <img id="preview_og_image" src="{{ site_file_url('og_image', 'assets/img/Microsoft Office Club Logo.png') }}" alt="OG Preview Image" class="max-h-24 max-w-full object-contain">
                                </div>
                            </div>

                            <div>
                                <input type="file" name="og_image" id="og_image" accept="image/*" onchange="previewImage(this, 'preview_og_image')" class="block w-full text-xs text-slate-500 dark:text-slate-400 file:mr-3 file:py-2 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-semibold file:bg-[#0067b8] file:text-white hover:file:bg-[#005da6] file:cursor-pointer cursor-pointer">
                            </div>
                        </div>
                    </div>
                </div>

                <hr class="border-slate-200/80 dark:border-slate-800">

                <!-- Tracking & Custom Scripts -->
                <div class="space-y-6">
                    <div>
                        <label for="google_analytics_id" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5 flex items-center gap-2">
                            <i class="fa-brands fa-google text-amber-500"></i>
                            <span>Google Analytics Measurement ID / GTM ID</span>
                        </label>
                        <input type="text" name="google_analytics_id" id="google_analytics_id" value="{{ old('google_analytics_id', $settings['google_analytics_id'] ?? '') }}" placeholder="G-XXXXXXXXXX or GTM-XXXXXXX" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">If provided, official Google tag tracking script is automatically injected.</p>
                    </div>

                    <div>
                        <label for="custom_head_scripts" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5 flex items-center gap-2">
                            <i class="fa-solid fa-code text-[#0067b8]"></i>
                            <span>Custom &lt;head&gt; Scripts / Verification Meta Tags</span>
                        </label>
                        <textarea name="custom_head_scripts" id="custom_head_scripts" rows="4" placeholder="<script>...</script> or <meta name='google-site-verification' ...>" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">{{ old('custom_head_scripts', $settings['custom_head_scripts'] ?? '') }}</textarea>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Directly injected into the &lt;head&gt; tag before closing.</p>
                    </div>

                    <div>
                        <label for="custom_footer_scripts" class="block text-xs font-bold text-slate-700 dark:text-slate-200 mb-1.5 flex items-center gap-2">
                            <i class="fa-solid fa-code text-purple-500"></i>
                            <span>Custom Footer Scripts (Before &lt;/body&gt;)</span>
                        </label>
                        <textarea name="custom_footer_scripts" id="custom_footer_scripts" rows="4" placeholder="<!-- Custom Live Chat or Tracking Scripts -->" class="w-full px-3.5 py-2.5 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white font-mono focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">{{ old('custom_footer_scripts', $settings['custom_footer_scripts'] ?? '') }}</textarea>
                        <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Directly injected at the very bottom of pages before closing &lt;/body&gt;.</p>
                    </div>
                </div>
            </div>

            <!-- Bottom Action Footer -->
            <div class="mt-8 pt-6 border-t border-slate-200/90 dark:border-slate-800 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p class="text-xs text-slate-500 dark:text-slate-400 flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-check text-emerald-500"></i>
                    <span>All settings are cached automatically for lightning-fast performance.</span>
                </p>

                <button type="submit" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 px-6 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005da6] text-white text-xs font-bold shadow-md shadow-[#0067b8]/25 transition-all">
                    <i class="fa-solid fa-floppy-disk text-xs"></i>
                    <span>Save All Changes</span>
                </button>
            </div>
        </form>
    </div>
</div>

<script>
    function switchSettingsTab(tabName) {
        // Update URL query param without reload
        const url = new URL(window.location.href);
        url.searchParams.set('tab', tabName);
        window.history.replaceState({}, '', url);

        // Update active hidden input
        document.getElementById('active_tab_input').value = tabName;

        // Reset all buttons
        document.querySelectorAll('.settings-tab-btn').forEach(btn => {
            btn.classList.remove('border-[#0067b8]', 'text-[#0067b8]', 'bg-white', 'dark:bg-slate-900', 'shadow-xs');
            btn.classList.add('border-transparent', 'text-slate-600', 'dark:text-slate-400');
        });

        // Highlight active button
        const activeBtn = document.getElementById('tab-btn-' + tabName);
        if (activeBtn) {
            activeBtn.classList.remove('border-transparent', 'text-slate-600', 'dark:text-slate-400');
            activeBtn.classList.add('border-[#0067b8]', 'text-[#0067b8]', 'bg-white', 'dark:bg-slate-900', 'shadow-xs');
        }

        // Hide all panes
        document.querySelectorAll('.settings-tab-pane').forEach(pane => {
            pane.classList.add('hidden');
        });

        // Show active pane
        const activePane = document.getElementById('tab-content-' + tabName);
        if (activePane) {
            activePane.classList.remove('hidden');
        }
    }

    function previewImage(input, previewId) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById(previewId).src = e.target.result;
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    // Dynamic Navbar Helpers
    function applyPresetToRow(selectEl) {
        const val = selectEl.value;
        if (!val) return;
        const row = selectEl.closest('.nav-item-row');
        if (!row) return;
        const urlInput = row.querySelector('.nav-url-input');
        if (urlInput) {
            urlInput.value = val;
        }
        selectEl.value = '';
    }

    function removeNavbarRow(btn) {
        const row = btn.closest('.nav-item-row');
        const tbody = document.getElementById('navbar-items-tbody');
        if (tbody && tbody.children.length <= 1) {
            alert('At least one navigation menu item should remain.');
            return;
        }
        if (row) {
            row.remove();
        }
    }

    function addNavbarRow(label = '', url = '', enabled = true, target = '_self') {
        const tbody = document.getElementById('navbar-items-tbody');
        if (!tbody) return;
        const newIndex = new Date().getTime();

        const tr = document.createElement('tr');
        tr.className = 'nav-item-row group hover:bg-white dark:hover:bg-slate-900/60 transition-colors';
        tr.dataset.index = newIndex;
        tr.innerHTML = `
            <td class="py-3 px-3 align-middle w-24">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="navbar_items[${newIndex}][enabled]" value="1" ${enabled ? 'checked' : ''} class="sr-only peer">
                    <div class="w-9 h-5 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-4 after:w-4 after:transition-all peer-checked:bg-emerald-500"></div>
                </label>
            </td>
            <td class="py-3 px-3 align-middle">
                <input type="text" name="navbar_items[${newIndex}][label]" value="${label}" placeholder="e.g. New Link" required class="w-full px-3 py-2 text-xs font-bold rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none">
            </td>
            <td class="py-3 px-3 align-middle">
                <div class="flex items-center gap-2">
                    <input type="text" name="navbar_items[${newIndex}][url]" value="${url}" placeholder="e.g. #plans or /login" required class="nav-url-input flex-1 px-3 py-2 text-xs font-mono rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none">
                    <select onchange="applyPresetToRow(this)" class="px-2.5 py-2 text-[11px] rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-900 text-slate-600 dark:text-slate-300 focus:ring-2 focus:ring-[#0067b8] outline-none">
                        <option value="">-- Presets --</option>
                        <option value="#key-features">#key-features</option>
                        <option value="#included-apps">#included-apps</option>
                        <option value="#plans">#plans</option>
                        <option value="#ai-features">#ai-features</option>
                        <option value="#how-it-works">#how-it-works</option>
                        <option value="#faq">#faq</option>
                        <option value="#contact-support">#contact-support</option>
                    </select>
                </div>
            </td>
            <td class="py-3 px-3 align-middle w-32">
                <select name="navbar_items[${newIndex}][target]" class="w-full px-2.5 py-2 text-xs rounded-xl border border-slate-300 dark:border-slate-700 bg-white dark:bg-slate-950 text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] outline-none">
                    <option value="_self" ${target === '_self' ? 'selected' : ''}>Same Tab (_self)</option>
                    <option value="_blank" ${target === '_blank' ? 'selected' : ''}>New Tab (_blank)</option>
                </select>
            </td>
            <td class="py-3 px-3 align-middle text-right w-20">
                <button type="button" onclick="removeNavbarRow(this)" class="w-8 h-8 rounded-xl bg-red-50 dark:bg-red-950/60 hover:bg-red-100 dark:hover:bg-red-900/80 text-red-600 dark:text-red-400 flex items-center justify-center transition-colors ml-auto" title="Remove Link">
                    <i class="fa-solid fa-trash text-xs"></i>
                </button>
            </td>
        `;
        tbody.appendChild(tr);
    }

    function resetNavbarDefaults() {
        if (!confirm('Are you sure you want to restore the default navigation menu links?')) return;
        const tbody = document.getElementById('navbar-items-tbody');
        if (!tbody) return;
        tbody.innerHTML = '';
        const defaultItems = [
            { label: 'Key Features', url: '#key-features' },
            { label: 'Included Apps', url: '#included-apps' },
            { label: 'Plans & Pricing', url: '#plans' },
            { label: 'AI Features', url: '#ai-features' },
            { label: 'How It Works', url: '#how-it-works' },
            { label: 'FAQ', url: '#faq' },
            { label: 'Contact', url: '#contact-support' }
        ];
        defaultItems.forEach(item => {
            addNavbarRow(item.label, item.url, true, '_self');
        });
    }

    // Initialize initial tab on load
    document.addEventListener('DOMContentLoaded', function() {
        const currentTab = '{{ $activeTab }}';
        if (currentTab) {
            switchSettingsTab(currentTab);
        }
    });
</script>
@endsection
