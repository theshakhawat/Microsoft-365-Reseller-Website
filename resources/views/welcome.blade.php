@extends('layouts.website.website')
@section('content')
    <!-- ========================================== -->
    <!-- COMPONENT: HERO SECTION                   -->
    <!-- ========================================== -->
    <section class="relative bg-grid-pattern pt-8 pb-16 lg:pt-20 lg:pb-28 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">

                <!-- Hero Copy -->
                <div class="lg:col-span-7 space-y-6 text-center lg:text-left" data-aos="fade-up">
                    <div
                        class="inline-flex items-center gap-2 bg-slate-100 border border-slate-200 px-3.5 py-1.5 rounded-full text-xs font-semibold text-brand-900">
                        <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
                        Localized Subscription Management for Bangladesh
                    </div>

                    <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-brand-900 tracking-tight leading-tight">
                        Microsoft 365,<br class="hidden sm:inline" />
                        <span class="text-brand-500">Built for the Way</span> Your Business Works.
                    </h1>

                    <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
                        Flexible Microsoft 365 licensing, automated Tenant onboarding, local BDT invoicing, and multi-tier
                        reseller commissions — managed from a single unified portal.
                    </p>

                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
                        <a href="#plans"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-brand-900 hover:bg-brand-600 text-white font-bold px-7 py-3.5 rounded-lg shadow-sm transition-all hover:translate-y-[-1px] min-h-[48px]">
                            <span>Explore Products</span>
                            <i class="fa-solid fa-arrow-right text-xs"></i>
                        </a>
                        <a href="pages/contact.html"
                            class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white border border-slate-300 hover:border-slate-400 text-slate-700 font-bold px-7 py-3.5 rounded-lg transition-all min-h-[48px]">
                            <i class="fa-solid fa-headset text-slate-400"></i>
                            <span>Talk to Local Sales</span>
                        </a>
                    </div>

                    <!-- Trust Badge Micro Metrics -->
                    <div class="pt-6 border-t border-slate-200/80 grid grid-cols-3 gap-4 text-center lg:text-left">
                        <div>
                            <p class="text-xl font-extrabold text-brand-900">BDT Invoicing</p>
                            <p class="text-xs text-slate-500 font-medium">bKash, Nagad & Cards</p>
                        </div>
                        <div>
                            <p class="text-xl font-extrabold text-brand-900">Instant</p>
                            <p class="text-xs text-slate-500 font-medium">Tenant Provisioning</p>
                        </div>
                        <div>
                            <p class="text-xl font-extrabold text-brand-900">24/7 Support</p>
                            <p class="text-xs text-slate-500 font-medium">Dhaka-based Engineers</p>
                        </div>
                    </div>
                </div>

                <!-- Hero Custom Visual Mockup (No Generic Stock Photo) -->
                <div class="lg:col-span-5" data-aos="fade-up" data-aos-delay="100">

                    <img src="{{ asset('assets/img/hero.png') }}" alt="Microsoft 365 Reseller Dashboard Preview"
                        class="rounded-xl border border-slate-600 shadow-lg">
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- COMPONENT: TRUST / CAPABILITY STRIP       -->
    <!-- ========================================== -->
    <section class="bg-brand-900 text-slate-300 py-6 border-y border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-wrap items-center justify-around gap-6 text-xs sm:text-sm font-semibold tracking-wide">
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-check-circle text-accent"></i>
                    <span>Flexible Monthly / Annual Billing</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-file-invoice-dollar text-accent"></i>
                    <span>Local VAT Compliant Invoices</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-network-wired text-accent"></i>
                    <span>Direct Tenant Integration</span>
                </div>
                <div class="flex items-center gap-2">
                    <i class="fa-solid fa-headset text-accent"></i>
                    <span>Dedicated Dhaka Migration Engineering</span>
                </div>
            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- COMPONENT: PRODUCT CATALOG & DYNAMIC PRICING -->
    <!-- ========================================== -->
    <section id="plans" class="py-16 lg:py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            <div class="text-center max-w-3xl mx-auto mb-12">
                <h2 class="text-xs font-extrabold uppercase tracking-widest text-brand-500 mb-2">Microsoft 365 Plans</h2>
                <p class="text-2xl sm:text-3xl font-extrabold text-brand-900">Tailored Licensing for Businesses in
                    Bangladesh</p>
                <p class="text-slate-600 mt-3 text-sm sm:text-base">Select your business requirement, adjust required seats,
                    and calculate instantly in BDT.</p>

                <!-- Pricing Cycle Switcher -->
                <div class="mt-8 inline-flex items-center bg-slate-100 p-1.5 rounded-xl border border-slate-200">
                    <button id="btn-monthly" onclick="switchBilling('monthly')"
                        class="px-5 py-2 text-xs sm:text-sm font-bold rounded-lg transition-all bg-white text-brand-900 shadow-sm">Monthly
                        Billing</button>
                    <button id="btn-annual" onclick="switchBilling('annual')"
                        class="px-5 py-2 text-xs sm:text-sm font-bold rounded-lg transition-all text-slate-600 hover:text-brand-900 flex items-center gap-1.5">
                        <span>Annual Commitment</span>
                        <span
                            class="bg-emerald-100 text-emerald-800 text-[10px] font-extrabold px-2 py-0.5 rounded-full">Save
                            ~15%</span>
                    </button>
                </div>
            </div>

            <!-- Dynamic Product Cards Grid -->
            <div class="grid md:grid-cols-3 gap-8 items-stretch">

                <!-- Product Card: Business Basic -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 flex flex-col justify-between hover:border-slate-300 transition-all hover:shadow-lg relative"
                    data-aos="fade-up">
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <div
                                class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-brand-500 text-xl font-bold">
                                <i class="fa-solid fa-cloud"></i>
                            </div>
                            <span class="text-xs font-semibold bg-slate-100 text-slate-600 px-3 py-1 rounded-full">Web &
                                Mobile Apps</span>
                        </div>
                        <h3 class="text-xl font-bold text-brand-900">Business Basic</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-6">Best for remote teams needing secure business email and
                            cloud storage.</p>

                        <!-- Dynamic Calculator -->
                        <div class="bg-slate-50 p-4 rounded-xl mb-6 border border-slate-100">
                            <div class="flex justify-between items-baseline mb-2">
                                <span class="text-xs font-semibold text-slate-500">Starting Price</span>
                                <div>
                                    <span id="price-basic" class="text-2xl font-extrabold text-brand-900">৳720</span>
                                    <span class="text-xs text-slate-500">/ user / mo</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-slate-200">
                                <label for="qty-basic" class="text-xs font-bold text-slate-700">License Qty:</label>
                                <div class="flex items-center border border-slate-300 rounded-lg bg-white overflow-hidden">
                                    <button onclick="adjustQty('basic', -1)"
                                        class="px-3 py-1 text-slate-600 hover:bg-slate-100 min-w-[32px] font-bold">-</button>
                                    <input id="qty-basic" type="number" value="5" min="1"
                                        onchange="calculatePrice('basic')"
                                        class="w-12 text-center text-xs font-bold focus:outline-none border-none py-1">
                                    <button onclick="adjustQty('basic', 1)"
                                        class="px-3 py-1 text-slate-600 hover:bg-slate-100 min-w-[32px] font-bold">+</button>
                                </div>
                            </div>

                            <div
                                class="mt-3 flex justify-between items-center text-xs text-slate-600 font-semibold pt-2 border-t border-slate-200/60">
                                <span>Estimated Total:</span>
                                <span id="total-basic" class="text-brand-500 font-extrabold text-sm">৳3,600 / mo</span>
                            </div>
                        </div>

                        <!-- Included Apps -->
                        <div class="space-y-3 mb-8">
                            <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Includes Web/Mobile Apps:
                            </p>
                            <ul class="text-xs text-slate-600 space-y-2">
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i>
                                    Business email (50 GB host mailbox)</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i>
                                    Teams, Exchange, OneDrive (1 TB)</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Web
                                    versions of Word, Excel, PowerPoint</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i>
                                    Standard Spam/Malware filtering</li>
                            </ul>
                        </div>
                    </div>

                    <a href="checkout/index.html?plan=basic"
                        class="w-full text-center bg-slate-100 hover:bg-brand-900 hover:text-white text-brand-900 font-bold py-3 rounded-lg transition-colors text-sm">
                        Select Business Basic
                    </a>
                </div>

                <!-- Product Card: Business Standard (Featured) -->
                <div class="bg-white rounded-2xl border-2 border-brand-500 p-6 sm:p-8 flex flex-col justify-between shadow-xl relative"
                    data-aos="fade-up" data-aos-delay="100">
                    <div
                        class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-brand-500 text-white text-[11px] font-extrabold uppercase px-4 py-1 rounded-full tracking-wider">
                        Most Popular Choice
                    </div>

                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <div
                                class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center text-brand-500 text-xl font-bold">
                                <i class="fa-solid fa-laptop-code"></i>
                            </div>
                            <span class="text-xs font-semibold bg-brand-50 text-brand-600 px-3 py-1 rounded-full">Desktop
                                Apps + Cloud</span>
                        </div>
                        <h3 class="text-xl font-bold text-brand-900">Business Standard</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-6">Complete suite with installed desktop apps across PCs,
                            Macs, and tablets.</p>

                        <!-- Dynamic Calculator -->
                        <div class="bg-slate-50 p-4 rounded-xl mb-6 border border-slate-100">
                            <div class="flex justify-between items-baseline mb-2">
                                <span class="text-xs font-semibold text-slate-500">Starting Price</span>
                                <div>
                                    <span id="price-standard" class="text-2xl font-extrabold text-brand-900">৳1,500</span>
                                    <span class="text-xs text-slate-500">/ user / mo</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-slate-200">
                                <label for="qty-standard" class="text-xs font-bold text-slate-700">License Qty:</label>
                                <div class="flex items-center border border-slate-300 rounded-lg bg-white overflow-hidden">
                                    <button onclick="adjustQty('standard', -1)"
                                        class="px-3 py-1 text-slate-600 hover:bg-slate-100 min-w-[32px] font-bold">-</button>
                                    <input id="qty-standard" type="number" value="10" min="1"
                                        onchange="calculatePrice('standard')"
                                        class="w-12 text-center text-xs font-bold focus:outline-none border-none py-1">
                                    <button onclick="adjustQty('standard', 1)"
                                        class="px-3 py-1 text-slate-600 hover:bg-slate-100 min-w-[32px] font-bold">+</button>
                                </div>
                            </div>

                            <div
                                class="mt-3 flex justify-between items-center text-xs text-slate-600 font-semibold pt-2 border-t border-slate-200/60">
                                <span>Estimated Total:</span>
                                <span id="total-standard" class="text-brand-500 font-extrabold text-sm">৳15,000 /
                                    mo</span>
                            </div>
                        </div>

                        <!-- Included Apps -->
                        <div class="space-y-3 mb-8">
                            <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Everything in Basic, plus:
                            </p>
                            <ul class="text-xs text-slate-600 space-y-2">
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i>
                                    Fully installed Outlook, Word, Excel, PowerPoint</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> 5
                                    PCs/Macs per user seat license</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i>
                                    Host webinars with attendee registration</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i>
                                    Access & Publisher (PC only)</li>
                            </ul>
                        </div>
                    </div>

                    <a href="checkout/index.html?plan=standard"
                        class="w-full text-center bg-brand-900 hover:bg-brand-600 text-white font-bold py-3.5 rounded-lg transition-colors text-sm shadow-md">
                        Buy Business Standard
                    </a>
                </div>

                <!-- Product Card: Business Premium -->
                <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 flex flex-col justify-between hover:border-slate-300 transition-all hover:shadow-lg relative"
                    data-aos="fade-up" data-aos-delay="200">
                    <div>
                        <div class="flex justify-between items-center mb-4">
                            <div
                                class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-brand-500 text-xl font-bold">
                                <i class="fa-solid fa-shield-virus"></i>
                            </div>
                            <span class="text-xs font-semibold bg-slate-100 text-slate-600 px-3 py-1 rounded-full">Advanced
                                Security</span>
                        </div>
                        <h3 class="text-xl font-bold text-brand-900">Business Premium</h3>
                        <p class="text-xs text-slate-500 mt-1 mb-6">Advanced cyber threat protection & device control for
                            scaling enterprise compliance.</p>

                        <!-- Dynamic Calculator -->
                        <div class="bg-slate-50 p-4 rounded-xl mb-6 border border-slate-100">
                            <div class="flex justify-between items-baseline mb-2">
                                <span class="text-xs font-semibold text-slate-500">Starting Price</span>
                                <div>
                                    <span id="price-premium" class="text-2xl font-extrabold text-brand-900">৳2,650</span>
                                    <span class="text-xs text-slate-500">/ user / mo</span>
                                </div>
                            </div>

                            <div class="flex items-center justify-between pt-3 border-t border-slate-200">
                                <label for="qty-premium" class="text-xs font-bold text-slate-700">License Qty:</label>
                                <div class="flex items-center border border-slate-300 rounded-lg bg-white overflow-hidden">
                                    <button onclick="adjustQty('premium', -1)"
                                        class="px-3 py-1 text-slate-600 hover:bg-slate-100 min-w-[32px] font-bold">-</button>
                                    <input id="qty-premium" type="number" value="10" min="1"
                                        onchange="calculatePrice('premium')"
                                        class="w-12 text-center text-xs font-bold focus:outline-none border-none py-1">
                                    <button onclick="adjustQty('premium', 1)"
                                        class="px-3 py-1 text-slate-600 hover:bg-slate-100 min-w-[32px] font-bold">+</button>
                                </div>
                            </div>

                            <div
                                class="mt-3 flex justify-between items-center text-xs text-slate-600 font-semibold pt-2 border-t border-slate-200/60">
                                <span>Estimated Total:</span>
                                <span id="total-premium" class="text-brand-500 font-extrabold text-sm">৳26,500 / mo</span>
                            </div>
                        </div>

                        <!-- Included Apps -->
                        <div class="space-y-3 mb-8">
                            <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Everything in Standard,
                                plus:</p>
                            <ul class="text-xs text-slate-600 space-y-2">
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i>
                                    Microsoft Defender for Business</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i>
                                    Intune MDM/MAM device management</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i>
                                    Azure Information Protection</li>
                                <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i>
                                    Zero-Trust conditional access policies</li>
                            </ul>
                        </div>
                    </div>

                    <a href="checkout/index.html?plan=premium"
                        class="w-full text-center bg-slate-100 hover:bg-brand-900 hover:text-white text-brand-900 font-bold py-3 rounded-lg transition-colors text-sm">
                        Select Business Premium
                    </a>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- COMPONENT: RESELLER PROGRAM HUB           -->
    <!-- ========================================== -->
    <section class="py-16 lg:py-24 bg-brand-900 text-white border-t border-slate-800">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid lg:grid-cols-12 gap-12 items-center">

                <div class="lg:col-span-6 space-y-6" data-aos="fade-right">
                    <span
                        class="text-xs font-bold uppercase tracking-widest text-accent bg-accent/10 px-3 py-1 rounded-full border border-accent/20">For
                        Local IT Providers & Agencies</span>
                    <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Build Your Recurring Microsoft Licensing
                        Business</h2>
                    <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
                        Expand your agency or IT firm revenue by provisioning Microsoft 365 for your clients. CloudSync
                        provides wholesale tier margins, automated billing, client tenant isolation, and API access.
                    </p>

                    <div class="grid sm:grid-cols-2 gap-4 pt-2">
                        <div class="p-4 bg-slate-800/80 rounded-xl border border-slate-700">
                            <i class="fa-solid fa-percent text-accent text-xl mb-2"></i>
                            <h4 class="font-bold text-sm">Wholesale Pricing</h4>
                            <p class="text-xs text-slate-400 mt-1">Tiered commission structures ensuring strong profit
                                margins on every seat.</p>
                        </div>
                        <div class="p-4 bg-slate-800/80 rounded-xl border border-slate-700">
                            <i class="fa-solid fa-wallet text-accent text-xl mb-2"></i>
                            <h4 class="font-bold text-sm">Prepaid Wallet & Invoicing</h4>
                            <p class="text-xs text-slate-400 mt-1">Instant seat activation using BDT prepaid balance or
                                bank transfers.</p>
                        </div>
                    </div>

                    <div class="pt-4 flex flex-wrap gap-4">
                        <a href="pages/reseller.html"
                            class="bg-accent hover:bg-accent-dark text-white font-bold px-6 py-3 rounded-lg text-sm transition-all">Become
                            a Reseller</a>
                        <a href="dashboard/reseller.html"
                            class="bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold px-6 py-3 rounded-lg text-sm border border-slate-700 transition-all">Preview
                            Reseller Portal</a>
                    </div>
                </div>

                <!-- Reseller Dashboard Mock Preview -->
                <div class="lg:col-span-6" data-aos="fade-up">
                    <img src="{{ asset('assets/img/licence.png') }}" alt="Reseller Portal Preview"
                        class="rounded-xl border border-slate-600 shadow-lg">
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- COMPONENT: FAQ ACCORDION                  -->
    <!-- ========================================== -->
    <section class="py-16 lg:py-24 bg-slate-50">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-xs font-extrabold uppercase tracking-widest text-brand-500 mb-2">Got Questions?</h2>
                <p class="text-2xl sm:text-3xl font-extrabold text-brand-900">Frequently Asked Questions</p>
            </div>

            <div class="space-y-4" id="faq-accordion">

                <!-- Item 1 -->
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden transition-all">
                    <button onclick="toggleFaq(1)"
                        class="w-full text-left p-5 font-bold text-brand-900 flex justify-between items-center gap-4 hover:bg-slate-50 min-h-[56px]">
                        <span>How do I pay in Bangladeshi Taka (BDT)?</span>
                        <i class="fa-solid fa-chevron-down text-slate-400 text-sm transition-transform duration-200"
                            id="faq-icon-1"></i>
                    </button>
                    <div id="faq-answer-1"
                        class="hidden px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        We support local payment gateways including bKash Merchant, Nagad, Visa/Mastercard issued by
                        Bangladeshi banks, and direct Electronic Fund Transfer (EFT) for enterprise billing. Official local
                        VAT invoices are provided with every order.
                    </div>
                </div>

                <!-- Item 2 -->
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden transition-all">
                    <button onclick="toggleFaq(2)"
                        class="w-full text-left p-5 font-bold text-brand-900 flex justify-between items-center gap-4 hover:bg-slate-50 min-h-[56px]">
                        <span>How long does tenant provisioning take after payment?</span>
                        <i class="fa-solid fa-chevron-down text-slate-400 text-sm transition-transform duration-200"
                            id="faq-icon-2"></i>
                    </button>
                    <div id="faq-answer-2"
                        class="hidden px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Existing Microsoft 365 tenants receive added license seats instantly via automated authorization.
                        New tenant domain creations typically complete within 5 to 15 minutes after checkout confirmation.
                    </div>
                </div>

                <!-- Item 3 -->
                <div class="bg-white rounded-xl border border-slate-200 overflow-hidden transition-all">
                    <button onclick="toggleFaq(3)"
                        class="w-full text-left p-5 font-bold text-brand-900 flex justify-between items-center gap-4 hover:bg-slate-50 min-h-[56px]">
                        <span>Can I adjust license seat quantities mid-month?</span>
                        <i class="fa-solid fa-chevron-down text-slate-400 text-sm transition-transform duration-200"
                            id="faq-icon-3"></i>
                    </button>
                    <div id="faq-answer-3"
                        class="hidden px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
                        Yes, you can add or reduce licenses anytime through the CloudSync Customer Portal. Mid-cycle
                        additions are prorated on a daily basis and billed to your next billing statement.
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- ========================================== -->
    <!-- COMPONENT: BOTTOM CALL TO ACTION          -->
    <!-- ========================================== -->
    <section class="py-16 bg-brand-900 text-white text-center relative overflow-hidden">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <h2 class="text-3xl font-extrabold sm:text-4xl tracking-tight mb-4">Ready to Modernize Your Office
                Productivity?</h2>
            <p class="text-slate-300 text-base max-w-2xl mx-auto mb-8">Get started with transparent BDT pricing, localized
                billing support, and seamless deployment.</p>
            <div class="flex flex-col sm:flex-row justify-center gap-4">
                <a href="auth/register.html"
                    class="bg-accent hover:bg-accent-dark text-white font-bold px-8 py-3.5 rounded-lg text-sm transition-all shadow-lg min-h-[48px] flex items-center justify-center">Create
                    Account</a>
                <a href="pages/contact.html"
                    class="bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold px-8 py-3.5 rounded-lg text-sm border border-slate-700 transition-all min-h-[48px] flex items-center justify-center">Contact
                    Local Engineers</a>
            </div>
        </div>
    </section>
@endsection
