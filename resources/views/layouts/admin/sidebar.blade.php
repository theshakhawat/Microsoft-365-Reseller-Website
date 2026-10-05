<!-- Mobile Backdrop Overlay -->
<div id="sidebar-backdrop" onclick="toggleSidebar()" class="fixed inset-0 bg-slate-900/60 backdrop-blur-xs z-40 lg:hidden opacity-0 pointer-events-none transition-opacity duration-300"></div>

<!-- Sidebar Aside -->
<aside id="main-sidebar" class="fixed lg:static top-0 bottom-0 left-0 w-64 sm:w-72 bg-white dark:bg-slate-900 border-r border-slate-200/90 dark:border-slate-800 z-50 flex flex-col justify-between transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out shrink-0">

    <!-- Sidebar Top: Brand & Navigation -->
    <div class="flex-1 flex flex-col overflow-y-auto">

        <!-- Brand Logo Header -->
        <div class="h-16 sm:h-20 px-5 sm:px-6 flex items-center justify-between border-b border-slate-100 dark:border-slate-800/80">
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-2.5">
                <img class="h-10 sm:h-12 w-auto max-w-[190px] object-contain transition-all" src="{{ site_file_url('header_logo', 'assets/img/Microsoft Office Club Logo.png') }}" alt="{{ site_setting('site_name', 'Microsoft Office Club') }}" />
            </a>
            <button onclick="toggleSidebar()" type="button" class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 dark:hover:bg-slate-800 dark:text-slate-400 cursor-pointer">
                <i class="fa-solid fa-xmark text-lg"></i>
            </button>
        </div>


        <!-- Navigation Menu Items -->
        <nav class="px-4 pt-3 space-y-1 flex-1">

            <!-- ========================================================= -->
            <!-- 1. MAIN / OVERVIEW                                        -->
            <!-- ========================================================= -->
            <div class="px-3 pb-1.5 pt-2 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                Core
            </div>

            <!-- Overview Dashboard -->
            <a href="{{ route('admin.dashboard') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.dashboard') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-gauge-high text-sm w-5 text-center {{ request()->routeIs('admin.dashboard') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>Overview Dashboard</span>
            </a>


            <!-- ========================================================= -->
            <!-- 2. SALES & CUSTOMERS                                      -->
            <!-- ========================================================= -->
            <div class="px-3 pb-1.5 pt-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                Sales & Customers
            </div>

            <!-- Users & Access Control (Customers & Admins) -->
            <div class="space-y-1">
                <button type="button" onclick="document.getElementById('users-submenu').classList.toggle('hidden'); document.getElementById('users-chevron').classList.toggle('rotate-180');" class="w-full flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.users.*') ? 'bg-[#0067b8]/10 text-[#0067b8] dark:bg-[#0067b8]/20 dark:text-blue-400' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-all cursor-pointer">
                    <div class="flex items-center gap-3">
                        <i class="fa-solid fa-users-gear text-sm w-5 text-center {{ request()->routeIs('admin.users.*') ? 'text-[#0067b8] dark:text-blue-400' : 'text-slate-400 dark:text-slate-500' }}"></i>
                        <span>Users & Roles</span>
                    </div>
                    <i id="users-chevron" class="fa-solid fa-chevron-down text-[10px] transition-transform duration-200 {{ request()->routeIs('admin.users.*') ? 'rotate-180 text-[#0067b8] dark:text-blue-400' : 'text-slate-400' }}"></i>
                </button>

                <div id="users-submenu" class="{{ request()->routeIs('admin.users.*') ? '' : 'hidden' }} pl-4 pr-1 py-1 space-y-1">
                    <!-- Customers Option -->
                    <a href="{{ route('admin.users.index', ['role' => 'user']) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-semibold {{ request()->routeIs('admin.users.index') && request('role', 'user') === 'user' ? 'bg-[#0067b8] text-white font-bold shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/60' }} transition-colors">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-user-group text-xs w-4 text-center {{ request()->routeIs('admin.users.index') && request('role', 'user') === 'user' ? 'text-white' : 'text-slate-400' }}"></i>
                            <span>Customers</span>
                        </div>
                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full {{ request()->routeIs('admin.users.index') && request('role', 'user') === 'user' ? 'bg-white/20 text-white' : 'bg-slate-200/80 dark:bg-slate-800 text-slate-600 dark:text-slate-400' }}">
                            {{ \App\Models\User::where('role', 'user')->count() }}
                        </span>
                    </a>

                    <!-- Admins Option -->
                    <a href="{{ route('admin.users.index', ['role' => 'admin']) }}" class="flex items-center justify-between px-3 py-2 rounded-lg text-xs font-semibold {{ request()->routeIs('admin.users.index') && request('role') === 'admin' ? 'bg-[#0067b8] text-white font-bold shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/60' }} transition-colors">
                        <div class="flex items-center gap-2.5">
                            <i class="fa-solid fa-user-shield text-xs w-4 text-center {{ request()->routeIs('admin.users.index') && request('role') === 'admin' ? 'text-white' : 'text-slate-400' }}"></i>
                            <span>Admins</span>
                        </div>
                        <span class="text-[10px] font-bold px-1.5 py-0.5 rounded-full {{ request()->routeIs('admin.users.index') && request('role') === 'admin' ? 'bg-white/20 text-white' : 'bg-purple-100 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300' }}">
                            {{ \App\Models\User::where('role', 'admin')->count() }}
                        </span>
                    </a>

                    <!-- Add User Option -->
                    <a href="{{ route('admin.users.create') }}" class="flex items-center gap-2.5 px-3 py-2 rounded-lg text-xs font-semibold {{ request()->routeIs('admin.users.create') ? 'bg-[#0067b8] text-white font-bold shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white hover:bg-slate-100 dark:hover:bg-slate-800/60' }} transition-colors">
                        <i class="fa-solid fa-user-plus text-xs w-4 text-center {{ request()->routeIs('admin.users.create') ? 'text-white' : 'text-emerald-500' }}"></i>
                        <span>Add New Account</span>
                    </a>
                </div>
            </div>

            <!-- Orders & Invoices -->
            @php
                $pendingOrdersCount = \App\Models\Order::where('payment_status', 'pending')->count();
                $activeSubscriptionsCount = \App\Models\Subscription::where('status', 'active')->count();
            @endphp
            <a href="{{ route('admin.orders.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.orders.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-cart-shopping text-sm w-5 text-center {{ request()->routeIs('admin.orders.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                    <span>Orders</span>
                </div>
                @if($pendingOrdersCount > 0)
                    <span class="px-2 py-0.5 text-[10px] font-black rounded-full {{ request()->routeIs('admin.orders.*') ? 'bg-white text-[#0067b8]' : 'bg-amber-500 text-white' }} animate-pulse">
                        {{ $pendingOrdersCount }}
                    </span>
                @endif
            </a>

            <!-- Customer Subscriptions & Licenses -->
            <a href="{{ route('admin.subscriptions.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.subscriptions.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-shield-halved text-sm w-5 text-center {{ request()->routeIs('admin.subscriptions.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                    <span>Subscriptions</span>
                </div>
                <span class="px-2 py-0.5 text-[10px] font-bold rounded-full {{ request()->routeIs('admin.subscriptions.*') ? 'bg-white/20 text-white' : 'bg-emerald-100 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400' }}">
                    {{ $activeSubscriptionsCount }}
                </span>
            </a>

            <!-- Payments Log -->
            <a href="{{ route('admin.payments.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.payments.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-money-bill-wave text-sm w-5 text-center {{ request()->routeIs('admin.payments.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>Payments Log</span>
            </a>

            <!-- Coupons & Discounts -->
            <a href="{{ route('admin.coupons.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.coupons.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-ticket text-sm w-5 text-center {{ request()->routeIs('admin.coupons.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>Coupons & Discounts</span>
            </a>

            <!-- Support Tickets -->
            @php
                $unreadTicketsCount = \App\Models\Ticket::where('is_read_by_admin', false)->count();
            @endphp
            <a href="{{ route('admin.tickets.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.tickets.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-headset text-sm w-5 text-center {{ request()->routeIs('admin.tickets.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                    <span>Support Tickets</span>
                </div>
                @if($unreadTicketsCount > 0)
                    <span class="px-2 py-0.5 text-[10px] font-black rounded-full {{ request()->routeIs('admin.tickets.*') ? 'bg-white text-[#0067b8]' : 'bg-red-500 text-white' }} animate-pulse">
                        {{ $unreadTicketsCount }}
                    </span>
                @endif
            </a>

            <!-- Contact Messages / Inquiries -->
            @php
                $unreadMessagesCount = \App\Models\ContactMessage::where('is_read', false)->count();
            @endphp
            <a href="{{ route('admin.contact-messages.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.contact-messages.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-envelope text-sm w-5 text-center {{ request()->routeIs('admin.contact-messages.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                    <span>Contact Inquiries</span>
                </div>
                @if($unreadMessagesCount > 0)
                    <span class="px-2 py-0.5 text-[10px] font-black rounded-full {{ request()->routeIs('admin.contact-messages.*') ? 'bg-white text-[#0067b8]' : 'bg-rose-500 text-white' }} animate-pulse">
                        {{ $unreadMessagesCount }}
                    </span>
                @endif
            </a>

            <!-- Notifications Center -->
            @php
                $adminUnreadNotifs = \App\Models\AppNotification::where(function ($q) {
                    $q->where('target_role', 'admin')->orWhereNull('user_id');
                })->where('is_read', false)->count();
            @endphp
            <a href="{{ route('admin.notifications.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.notifications.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-bell text-sm w-5 text-center {{ request()->routeIs('admin.notifications.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                    <span>Notifications</span>
                </div>
                @if($adminUnreadNotifs > 0)
                    <span class="px-2 py-0.5 text-[10px] font-black rounded-full {{ request()->routeIs('admin.notifications.*') ? 'bg-white text-[#0067b8]' : 'bg-blue-600 text-white' }} animate-pulse">
                        {{ $adminUnreadNotifs }}
                    </span>
                @endif
            </a>


            <!-- ========================================================= -->
            <!-- 3. UI / APPEARANCE (Landing Page & Content)               -->
            <!-- ========================================================= -->
            <div class="px-3 pb-1.5 pt-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center justify-between">
                <span>UI & Appearance</span>
                <i class="fa-solid fa-palette text-[10px] text-slate-400"></i>
            </div>

            <!-- Hero & CTA Banners -->
            <a href="{{ route('admin.site-settings.index', ['tab' => 'banner']) }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.site-settings.*') && request('tab') === 'banner' ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-rectangle-ad text-sm w-5 text-center {{ request()->routeIs('admin.site-settings.*') && request('tab') === 'banner' ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>Hero & Banners</span>
            </a>

            <!-- Pricing Plans -->
            <a href="{{ route('admin.plans.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.plans.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-box-archive text-sm w-5 text-center {{ request()->routeIs('admin.plans.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>Pricing Plans</span>
            </a>

            <!-- Included Apps -->
            <a href="{{ route('admin.included-apps.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.included-apps.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-shapes text-sm w-5 text-center {{ request()->routeIs('admin.included-apps.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>Included Apps</span>
            </a>

            <!-- Key Features -->
            <a href="{{ route('admin.key-features.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.key-features.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-wand-magic-sparkles text-sm w-5 text-center {{ request()->routeIs('admin.key-features.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>Key Features</span>
            </a>

            <!-- AI Features -->
            <a href="{{ route('admin.ai-features.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.ai-features.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-robot text-sm w-5 text-center {{ request()->routeIs('admin.ai-features.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>AI Features</span>
            </a>

            <!-- How It Works (4 Steps) -->
            <a href="{{ route('admin.how-it-works.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.how-it-works.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-list-check text-sm w-5 text-center {{ request()->routeIs('admin.how-it-works.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>How It Works</span>
            </a>

            <!-- Trusted Brands -->
            <a href="{{ route('admin.trusted-brands.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.trusted-brands.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-award text-sm w-5 text-center {{ request()->routeIs('admin.trusted-brands.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>Trusted Brands</span>
            </a>

            <!-- More Benefits -->
            <a href="{{ route('admin.more-benefits.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.more-benefits.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-gift text-sm w-5 text-center {{ request()->routeIs('admin.more-benefits.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>More Benefits</span>
            </a>

            <!-- FAQs (Did you know?) -->
            <a href="{{ route('admin.faqs.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.faqs.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-circle-question text-sm w-5 text-center {{ request()->routeIs('admin.faqs.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>FAQs</span>
            </a>


            <!-- ========================================================= -->
            <!-- 4. SETTINGS & CONFIGURATION                               -->
            <!-- ========================================================= -->
            <div class="px-3 pb-1.5 pt-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center justify-between">
                <span>Settings</span>
                <i class="fa-solid fa-gear text-[10px] text-slate-400"></i>
            </div>

            <!-- Site & Footer Settings -->
            <a href="{{ route('admin.site-settings.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.site-settings.*') && !request('tab') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : (request()->routeIs('admin.site-settings.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white') }} transition-colors">
                <i class="fa-solid fa-sliders text-sm w-5 text-center {{ request()->routeIs('admin.site-settings.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>Site, Footer & Branding</span>
            </a>

            <!-- SEO & Webmaster Settings -->
            <a href="{{ route('admin.site-settings.index', ['tab' => 'seo']) }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.site-settings.*') && request('tab') === 'seo' ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-magnifying-glass-chart text-sm w-5 text-center {{ request()->routeIs('admin.site-settings.*') && request('tab') === 'seo' ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>SEO & Scripts</span>
            </a>

            <!-- Payment Gateways -->
            <a href="{{ route('admin.payment-methods.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-bold {{ request()->routeIs('admin.payment-methods.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-credit-card text-sm w-5 text-center {{ request()->routeIs('admin.payment-methods.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>Payment Gateways</span>
            </a>

            <!-- SMTP Settings -->
            <a href="{{ route('admin.smtp.edit') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.smtp.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-server text-sm w-5 text-center {{ request()->routeIs('admin.smtp.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>SMTP Mail Settings</span>
            </a>

            <!-- Admin Profile -->
            <a href="{{ route('admin.profile') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.profile') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-regular fa-user text-sm w-5 text-center {{ request()->routeIs('admin.profile') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>Admin Profile</span>
            </a>


            <!-- ========================================================= -->
            <!-- 5. SECURITY                                               -->
            <!-- ========================================================= -->
            <div class="px-3 pb-1.5 pt-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center justify-between">
                <span>Security</span>
                <i class="fa-solid fa-shield-halved text-[10px] text-slate-400"></i>
            </div>

            <!-- Change Password & Credentials -->
            <a href="{{ route('admin.password') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.password') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-key text-sm w-5 text-center {{ request()->routeIs('admin.password') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>Password & Security</span>
            </a>


            <!-- ========================================================= -->
            <!-- 6. SYSTEM & MAINTENANCE                                   -->
            <!-- ========================================================= -->
            <div class="px-3 pb-1.5 pt-4 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500 flex items-center justify-between">
                <span>System</span>
                <i class="fa-solid fa-microchip text-[10px] text-slate-400"></i>
            </div>

            <!-- System Logs -->
            <a href="{{ route('admin.logs.index') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.logs.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <i class="fa-solid fa-terminal text-sm w-5 text-center {{ request()->routeIs('admin.logs.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                <span>System Logs</span>
            </a>

            <!-- Queue & Background Jobs -->
            @php
                $sidebarFailedJobsCount = \Illuminate\Support\Facades\Schema::hasTable('failed_jobs') ? \Illuminate\Support\Facades\DB::table('failed_jobs')->count() : 0;
                $sidebarPendingJobsCount = \Illuminate\Support\Facades\Schema::hasTable('jobs') ? \Illuminate\Support\Facades\DB::table('jobs')->count() : 0;
            @endphp
            <a href="{{ route('admin.queue.index') }}" class="flex items-center justify-between px-3.5 py-2.5 rounded-xl text-xs font-semibold {{ request()->routeIs('admin.queue.*') ? 'bg-[#0067b8] text-white shadow-sm shadow-[#0067b8]/20 font-bold' : 'text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white' }} transition-colors">
                <div class="flex items-center gap-3">
                    <i class="fa-solid fa-gears text-sm w-5 text-center {{ request()->routeIs('admin.queue.*') ? 'text-white' : 'text-slate-400 dark:text-slate-500' }}"></i>
                    <span>Queue & Jobs</span>
                </div>
                @if($sidebarFailedJobsCount > 0)
                    <span class="px-2 py-0.5 text-[10px] font-black rounded-full {{ request()->routeIs('admin.queue.*') ? 'bg-white text-red-600' : 'bg-red-500 text-white' }} animate-pulse">
                        {{ $sidebarFailedJobsCount }} Failed
                    </span>
                @elseif($sidebarPendingJobsCount > 0)
                    <span class="px-2 py-0.5 text-[10px] font-bold rounded-full {{ request()->routeIs('admin.queue.*') ? 'bg-white/20 text-white' : 'bg-sky-100 dark:bg-sky-950/60 text-[#0067b8] dark:text-sky-400' }}">
                        {{ $sidebarPendingJobsCount }}
                    </span>
                @endif
            </a>

            <!-- Optimize & Clear Cache -->
            <a href="{{ route('admin.clear-cache') }}" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-emerald-50 dark:hover:bg-emerald-950/40 hover:text-emerald-700 dark:hover:text-emerald-300 transition-colors" title="Clear all caches & optimize storage">
                <i class="fa-solid fa-arrows-rotate text-sm w-5 text-center text-emerald-500"></i>
                <span>Optimize System</span>
            </a>

            <!-- Live Website -->
            <a href="{{ route('home') }}" target="_blank" class="flex items-center gap-3 px-3.5 py-2.5 rounded-xl text-xs font-semibold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-900 dark:hover:text-white transition-colors">
                <i class="fa-solid fa-arrow-up-right-from-square text-sm w-5 text-center text-slate-400 dark:text-slate-500"></i>
                <span>Live Website</span>
            </a>

        </nav>
    </div>

    <!-- Sidebar Bottom: Admin Card -->
    <div class="p-4 border-t border-slate-100 dark:border-slate-800/80 bg-slate-50/60 dark:bg-slate-900/60">
        <div class="flex items-center justify-between">
            <div class="flex items-center gap-3 min-w-0">
                @if(Auth::user()->photo)
                    <img src="{{ asset(Auth::user()->photo) }}" class="w-9 h-9 rounded-xl object-cover shrink-0 border border-slate-200 dark:border-slate-700" alt="{{ Auth::user()->name }}" />
                @else
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-600 text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-xs">
                        ADM
                    </div>
                @endif
                <div class="min-w-0 flex-1">
                    <p class="text-xs font-bold text-slate-900 dark:text-white truncate">{{ Auth::user()->name }}</p>
                    <p class="text-[11px] text-purple-600 dark:text-purple-400 font-semibold truncate">Super Admin</p>
                </div>
            </div>
            <form action="{{ route('logout') }}" method="POST" class="shrink-0">
                @csrf
                <button type="submit" class="p-2 text-slate-400 hover:text-red-500 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-950/50 rounded-xl transition-colors cursor-pointer" title="Sign Out">
                    <i class="fa-solid fa-arrow-right-from-bracket text-xs"></i>
                </button>
            </form>
        </div>
    </div>

</aside>
