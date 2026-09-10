<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>CloudSync | Microsoft 365 Reseller & Subscription Management Platform Bangladesh</title>
  <meta name="description" content="Manage, provision, and scale Microsoft 365 subscriptions in Bangladesh. Enterprise billing, BDT invoicing, bKash/Nagad support, and downstream reseller portals.">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#f0f5fa',
              100: '#e1ebd6',
              500: '#0067b8', // Refined MS Blue
              600: '#005da6',
              900: '#0b192c', // Deep Navy Primary
              950: '#060e19',
            },
            accent: {
              DEFAULT: '#00a4ef',
              dark: '#0078d4'
            }
          },
          fontFamily: {
            sans: ['Plus Jakarta Sans', 'Inter', 'sans-serif'],
          }
        }
      }
    }
  </script>

  <!-- Typography & Icons -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
  <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />

  <style>
    body { font-family: 'Plus Jakarta Sans', sans-serif; }
    .glass-card { background: rgba(255, 255, 255, 0.85); backdrop-filter: blur(12px); }
    .bg-grid-pattern {
      background-image: radial-gradient(rgba(11, 25, 44, 0.08) 1px, transparent 1px);
      background-size: 24px 24px;
    }
    .custom-scrollbar::-webkit-scrollbar { width: 6px; height: 6px; }
    .custom-scrollbar::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }
  </style>
</head>
<body class="bg-[#f8fafc] text-slate-800 antialiased selection:bg-brand-500 selection:text-white min-h-screen flex flex-col">

  <!-- ========================================== -->
  <!-- COMPONENT: NAVBAR                          -->
  <!-- ========================================== -->
  <header id="navbar" class="sticky top-0 z-50 transition-all duration-300 bg-white/90 backdrop-blur-md border-b border-slate-200/80">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-20">

        <!-- Brand Logo -->
        <a href="index.html" class="flex items-center gap-3 group">
          <div class="w-10 h-10 bg-brand-900 rounded-lg flex items-center justify-center text-white font-bold text-xl shadow-md transition-transform group-hover:scale-105">
            <i class="fa-solid me-0 fa-cubes text-accent"></i>
          </div>
          <div class="flex flex-col">
            <span class="font-extrabold text-xl tracking-tight text-brand-900">CloudSync</span>
            <span class="text-[10px] font-semibold text-slate-500 uppercase tracking-widest -mt-1">Bangladesh</span>
          </div>
        </a>

        <!-- Desktop Navigation Links -->
        <nav class="hidden lg:flex items-center gap-8 text-sm font-semibold text-slate-600">
          <a href="pages/microsoft-365.html" class="hover:text-brand-500 transition-colors">Products</a>
          <a href="pages/business-solutions.html" class="hover:text-brand-500 transition-colors">Solutions</a>
          <a href="pages/pricing.html" class="hover:text-brand-500 transition-colors">Pricing</a>
          <a href="pages/reseller.html" class="hover:text-brand-500 transition-colors flex items-center gap-1.5">
            <span>Reseller Hub</span>
            <span class="bg-brand-50 text-brand-500 text-[10px] font-bold px-2 py-0.5 rounded-full border border-brand-100">B2B</span>
          </a>
          <a href="pages/faq.html" class="hover:text-brand-500 transition-colors">FAQ</a>
          <a href="pages/contact.html" class="hover:text-brand-500 transition-colors">Support</a>
        </nav>

        <!-- Desktop Action Buttons -->
        <div class="hidden lg:flex items-center gap-4">
          <a href="auth/login.html" class="text-sm font-semibold text-slate-700 hover:text-brand-500 px-3 py-2 transition-colors">Log In</a>
          <a href="auth/register.html" class="bg-brand-900 hover:bg-brand-600 text-white text-sm font-bold px-5 py-2.5 rounded-lg transition-all shadow-sm hover:shadow-md active:scale-95">Get Started</a>
        </div>

        <!-- Mobile Hamburger Toggle -->
        <div class="flex lg:hidden items-center">
          <button id="mobile-menu-btn" type="button" class="p-2.5 rounded-lg text-slate-600 hover:bg-slate-100 focus:outline-none min-w-[44px] min-h-[44px] flex items-center justify-center" aria-label="Toggle Menu">
            <i class="fa-solid fa-bars text-xl" id="menu-icon"></i>
          </button>
        </div>
      </div>
    </div>

    <!-- Mobile Drawer Menu -->
    <div id="mobile-menu" class="hidden lg:hidden border-b border-slate-200 bg-white px-4 pt-2 pb-6 space-y-3">
      <a href="pages/microsoft-365.html" class="block px-3 py-2.5 rounded-md text-base font-medium text-slate-700 hover:bg-slate-50">Microsoft 365 Products</a>
      <a href="pages/business-solutions.html" class="block px-3 py-2.5 rounded-md text-base font-medium text-slate-700 hover:bg-slate-50">Business Solutions</a>
      <a href="pages/pricing.html" class="block px-3 py-2.5 rounded-md text-base font-medium text-slate-700 hover:bg-slate-50">Plans & Pricing</a>
      <a href="pages/reseller.html" class="block px-3 py-2.5 rounded-md text-base font-medium text-slate-700 hover:bg-slate-50">Reseller Program</a>
      <a href="pages/faq.html" class="block px-3 py-2.5 rounded-md text-base font-medium text-slate-700 hover:bg-slate-50">Knowledge Base & FAQ</a>
      <a href="pages/contact.html" class="block px-3 py-2.5 rounded-md text-base font-medium text-slate-700 hover:bg-slate-50">Contact & Support</a>
      <div class="pt-4 border-t border-slate-100 flex flex-col gap-2">
        <a href="auth/login.html" class="w-full text-center py-2.5 font-semibold text-slate-700 border border-slate-200 rounded-lg">Log In</a>
        <a href="auth/register.html" class="w-full text-center py-2.5 font-semibold bg-brand-900 text-white rounded-lg">Get Started</a>
      </div>
    </div>
  </header>

  <main class="flex-grow">
    <!-- ========================================== -->
    <!-- COMPONENT: HERO SECTION                   -->
    <!-- ========================================== -->
    <section class="relative bg-grid-pattern pt-8 pb-16 lg:pt-20 lg:pb-28 overflow-hidden">
      <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid lg:grid-cols-12 gap-12 lg:gap-8 items-center">

          <!-- Hero Copy -->
          <div class="lg:col-span-7 space-y-6 text-center lg:text-left" data-aos="fade-up">
            <div class="inline-flex items-center gap-2 bg-slate-100 border border-slate-200 px-3.5 py-1.5 rounded-full text-xs font-semibold text-brand-900">
              <span class="w-2 h-2 rounded-full bg-emerald-500 animate-pulse"></span>
              Localized Subscription Management for Bangladesh
            </div>

            <h1 class="text-3xl sm:text-4xl lg:text-5xl font-extrabold text-brand-900 tracking-tight leading-tight">
              Microsoft 365,<br class="hidden sm:inline"/>
              <span class="text-brand-500">Built for the Way</span> Your Business Works.
            </h1>

            <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto lg:mx-0 leading-relaxed font-normal">
              Flexible Microsoft 365 licensing, automated Tenant onboarding, local BDT invoicing, and multi-tier reseller commissions — managed from a single unified portal.
            </p>

            <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4 pt-2">
              <a href="#plans" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-brand-900 hover:bg-brand-600 text-white font-bold px-7 py-3.5 rounded-lg shadow-sm transition-all hover:translate-y-[-1px] min-h-[48px]">
                <span>Explore Products</span>
                <i class="fa-solid fa-arrow-right text-xs"></i>
              </a>
              <a href="pages/contact.html" class="w-full sm:w-auto inline-flex items-center justify-center gap-2 bg-white border border-slate-300 hover:border-slate-400 text-slate-700 font-bold px-7 py-3.5 rounded-lg transition-all min-h-[48px]">
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
          <div class="lg:col-span-5" data-aos="fade-left" data-aos-delay="100">
            <div class="bg-brand-900 rounded-2xl p-4 sm:p-6 shadow-2xl text-white relative border border-slate-700">
              <!-- Window Header -->
              <div class="flex items-center justify-between pb-4 mb-4 border-b border-slate-800">
                <div class="flex items-center gap-2">
                  <span class="w-3 h-3 rounded-full bg-rose-500 inline-block"></span>
                  <span class="w-3 h-3 rounded-full bg-amber-500 inline-block"></span>
                  <span class="w-3 h-3 rounded-full bg-emerald-500 inline-block"></span>
                  <span class="text-xs font-mono text-slate-400 ml-2">cloudsync.com.bd/tenant</span>
                </div>
                <span class="text-xs font-semibold px-2 py-0.5 bg-emerald-500/20 text-emerald-400 rounded border border-emerald-500/30">Active Tenant</span>
              </div>

              <!-- Subscription Status Snapshot -->
              <div class="space-y-4">
                <div class="bg-slate-800/80 rounded-xl p-4 border border-slate-700/60">
                  <div class="flex justify-between items-start mb-2">
                    <div>
                      <p class="text-xs text-slate-400 font-medium">Organization Tenant</p>
                      <h4 class="font-bold text-sm text-white">Acme Logistics BD Ltd.</h4>
                    </div>
                    <span class="bg-brand-500 text-[10px] uppercase font-bold px-2 py-0.5 rounded">M365 Enterprise</span>
                  </div>
                  <p class="text-xs text-slate-400 font-mono">Domain: acmelogistics.onmicrosoft.com</p>
                </div>

                <!-- Live License Counter Card -->
                <div class="grid grid-cols-2 gap-3">
                  <div class="bg-slate-800/50 p-3 rounded-lg border border-slate-700/40">
                    <span class="text-xs text-slate-400">Total Allocated</span>
                    <p class="text-lg font-bold text-white mt-1">45 / 50 <span class="text-xs text-slate-400 font-normal">Seats</span></p>
                    <div class="w-full bg-slate-700 rounded-full h-1.5 mt-2">
                      <div class="bg-accent h-1.5 rounded-full" style="width: 90%"></div>
                    </div>
                  </div>
                  <div class="bg-slate-800/50 p-3 rounded-lg border border-slate-700/40">
                    <span class="text-xs text-slate-400">Next Renewal</span>
                    <p class="text-lg font-bold text-emerald-400 mt-1">Oct 12, 2026</p>
                    <span class="text-[10px] text-slate-400">Auto-Debit: bKash Merchant</span>
                  </div>
                </div>

                <!-- Micro Action Panel -->
                <div class="pt-2 flex items-center justify-between text-xs">
                  <span class="text-slate-400"><i class="fa-solid fa-shield-halved text-emerald-400 mr-1"></i> Global Admin Authorized</span>
                  <a href="dashboard/customer.html" class="text-accent hover:underline font-semibold flex items-center gap-1">
                    Manage Licenses <i class="fa-solid fa-angle-right text-[10px]"></i>
                  </a>
                </div>
              </div>
            </div>
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
          <p class="text-2xl sm:text-3xl font-extrabold text-brand-900">Tailored Licensing for Businesses in Bangladesh</p>
          <p class="text-slate-600 mt-3 text-sm sm:text-base">Select your business requirement, adjust required seats, and calculate instantly in BDT.</p>

          <!-- Pricing Cycle Switcher -->
          <div class="mt-8 inline-flex items-center bg-slate-100 p-1.5 rounded-xl border border-slate-200">
            <button id="btn-monthly" onclick="switchBilling('monthly')" class="px-5 py-2 text-xs sm:text-sm font-bold rounded-lg transition-all bg-white text-brand-900 shadow-sm">Monthly Billing</button>
            <button id="btn-annual" onclick="switchBilling('annual')" class="px-5 py-2 text-xs sm:text-sm font-bold rounded-lg transition-all text-slate-600 hover:text-brand-900 flex items-center gap-1.5">
              <span>Annual Commitment</span>
              <span class="bg-emerald-100 text-emerald-800 text-[10px] font-extrabold px-2 py-0.5 rounded-full">Save ~15%</span>
            </button>
          </div>
        </div>

        <!-- Dynamic Product Cards Grid -->
        <div class="grid md:grid-cols-3 gap-8 items-stretch">

          <!-- Product Card: Business Basic -->
          <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 flex flex-col justify-between hover:border-slate-300 transition-all hover:shadow-lg relative" data-aos="fade-up">
            <div>
              <div class="flex justify-between items-center mb-4">
                <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-brand-500 text-xl font-bold">
                  <i class="fa-solid fa-cloud"></i>
                </div>
                <span class="text-xs font-semibold bg-slate-100 text-slate-600 px-3 py-1 rounded-full">Web & Mobile Apps</span>
              </div>
              <h3 class="text-xl font-bold text-brand-900">Business Basic</h3>
              <p class="text-xs text-slate-500 mt-1 mb-6">Best for remote teams needing secure business email and cloud storage.</p>

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
                    <button onclick="adjustQty('basic', -1)" class="px-3 py-1 text-slate-600 hover:bg-slate-100 min-w-[32px] font-bold">-</button>
                    <input id="qty-basic" type="number" value="5" min="1" onchange="calculatePrice('basic')" class="w-12 text-center text-xs font-bold focus:outline-none border-none py-1">
                    <button onclick="adjustQty('basic', 1)" class="px-3 py-1 text-slate-600 hover:bg-slate-100 min-w-[32px] font-bold">+</button>
                  </div>
                </div>

                <div class="mt-3 flex justify-between items-center text-xs text-slate-600 font-semibold pt-2 border-t border-slate-200/60">
                  <span>Estimated Total:</span>
                  <span id="total-basic" class="text-brand-500 font-extrabold text-sm">৳3,600 / mo</span>
                </div>
              </div>

              <!-- Included Apps -->
              <div class="space-y-3 mb-8">
                <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Includes Web/Mobile Apps:</p>
                <ul class="text-xs text-slate-600 space-y-2">
                  <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Business email (50 GB host mailbox)</li>
                  <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Teams, Exchange, OneDrive (1 TB)</li>
                  <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Web versions of Word, Excel, PowerPoint</li>
                  <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Standard Spam/Malware filtering</li>
                </ul>
              </div>
            </div>

            <a href="checkout/index.html?plan=basic" class="w-full text-center bg-slate-100 hover:bg-brand-900 hover:text-white text-brand-900 font-bold py-3 rounded-lg transition-colors text-sm">
              Select Business Basic
            </a>
          </div>

          <!-- Product Card: Business Standard (Featured) -->
          <div class="bg-white rounded-2xl border-2 border-brand-500 p-6 sm:p-8 flex flex-col justify-between shadow-xl relative" data-aos="fade-up" data-aos-delay="100">
            <div class="absolute -top-3.5 left-1/2 -translate-x-1/2 bg-brand-500 text-white text-[11px] font-extrabold uppercase px-4 py-1 rounded-full tracking-wider">
              Most Popular Choice
            </div>

            <div>
              <div class="flex justify-between items-center mb-4">
                <div class="w-12 h-12 bg-brand-50 rounded-xl flex items-center justify-center text-brand-500 text-xl font-bold">
                  <i class="fa-solid fa-laptop-code"></i>
                </div>
                <span class="text-xs font-semibold bg-brand-50 text-brand-600 px-3 py-1 rounded-full">Desktop Apps + Cloud</span>
              </div>
              <h3 class="text-xl font-bold text-brand-900">Business Standard</h3>
              <p class="text-xs text-slate-500 mt-1 mb-6">Complete suite with installed desktop apps across PCs, Macs, and tablets.</p>

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
                    <button onclick="adjustQty('standard', -1)" class="px-3 py-1 text-slate-600 hover:bg-slate-100 min-w-[32px] font-bold">-</button>
                    <input id="qty-standard" type="number" value="10" min="1" onchange="calculatePrice('standard')" class="w-12 text-center text-xs font-bold focus:outline-none border-none py-1">
                    <button onclick="adjustQty('standard', 1)" class="px-3 py-1 text-slate-600 hover:bg-slate-100 min-w-[32px] font-bold">+</button>
                  </div>
                </div>

                <div class="mt-3 flex justify-between items-center text-xs text-slate-600 font-semibold pt-2 border-t border-slate-200/60">
                  <span>Estimated Total:</span>
                  <span id="total-standard" class="text-brand-500 font-extrabold text-sm">৳15,000 / mo</span>
                </div>
              </div>

              <!-- Included Apps -->
              <div class="space-y-3 mb-8">
                <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Everything in Basic, plus:</p>
                <ul class="text-xs text-slate-600 space-y-2">
                  <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Fully installed Outlook, Word, Excel, PowerPoint</li>
                  <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> 5 PCs/Macs per user seat license</li>
                  <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Host webinars with attendee registration</li>
                  <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Access & Publisher (PC only)</li>
                </ul>
              </div>
            </div>

            <a href="checkout/index.html?plan=standard" class="w-full text-center bg-brand-900 hover:bg-brand-600 text-white font-bold py-3.5 rounded-lg transition-colors text-sm shadow-md">
              Buy Business Standard
            </a>
          </div>

          <!-- Product Card: Business Premium -->
          <div class="bg-white rounded-2xl border border-slate-200 p-6 sm:p-8 flex flex-col justify-between hover:border-slate-300 transition-all hover:shadow-lg relative" data-aos="fade-up" data-aos-delay="200">
            <div>
              <div class="flex justify-between items-center mb-4">
                <div class="w-12 h-12 bg-slate-100 rounded-xl flex items-center justify-center text-brand-500 text-xl font-bold">
                  <i class="fa-solid fa-shield-virus"></i>
                </div>
                <span class="text-xs font-semibold bg-slate-100 text-slate-600 px-3 py-1 rounded-full">Advanced Security</span>
              </div>
              <h3 class="text-xl font-bold text-brand-900">Business Premium</h3>
              <p class="text-xs text-slate-500 mt-1 mb-6">Advanced cyber threat protection & device control for scaling enterprise compliance.</p>

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
                    <button onclick="adjustQty('premium', -1)" class="px-3 py-1 text-slate-600 hover:bg-slate-100 min-w-[32px] font-bold">-</button>
                    <input id="qty-premium" type="number" value="10" min="1" onchange="calculatePrice('premium')" class="w-12 text-center text-xs font-bold focus:outline-none border-none py-1">
                    <button onclick="adjustQty('premium', 1)" class="px-3 py-1 text-slate-600 hover:bg-slate-100 min-w-[32px] font-bold">+</button>
                  </div>
                </div>

                <div class="mt-3 flex justify-between items-center text-xs text-slate-600 font-semibold pt-2 border-t border-slate-200/60">
                  <span>Estimated Total:</span>
                  <span id="total-premium" class="text-brand-500 font-extrabold text-sm">৳26,500 / mo</span>
                </div>
              </div>

              <!-- Included Apps -->
              <div class="space-y-3 mb-8">
                <p class="text-xs font-bold text-slate-700 uppercase tracking-wider">Everything in Standard, plus:</p>
                <ul class="text-xs text-slate-600 space-y-2">
                  <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Microsoft Defender for Business</li>
                  <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Intune MDM/MAM device management</li>
                  <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Azure Information Protection</li>
                  <li class="flex items-center gap-2"><i class="fa-solid fa-check text-emerald-500"></i> Zero-Trust conditional access policies</li>
                </ul>
              </div>
            </div>

            <a href="checkout/index.html?plan=premium" class="w-full text-center bg-slate-100 hover:bg-brand-900 hover:text-white text-brand-900 font-bold py-3 rounded-lg transition-colors text-sm">
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
            <span class="text-xs font-bold uppercase tracking-widest text-accent bg-accent/10 px-3 py-1 rounded-full border border-accent/20">For Local IT Providers & Agencies</span>
            <h2 class="text-3xl sm:text-4xl font-extrabold tracking-tight">Build Your Recurring Microsoft Licensing Business</h2>
            <p class="text-slate-300 text-sm sm:text-base leading-relaxed">
              Expand your agency or IT firm revenue by provisioning Microsoft 365 for your clients. CloudSync provides wholesale tier margins, automated billing, client tenant isolation, and API access.
            </p>

            <div class="grid sm:grid-cols-2 gap-4 pt-2">
              <div class="p-4 bg-slate-800/80 rounded-xl border border-slate-700">
                <i class="fa-solid fa-percent text-accent text-xl mb-2"></i>
                <h4 class="font-bold text-sm">Wholesale Pricing</h4>
                <p class="text-xs text-slate-400 mt-1">Tiered commission structures ensuring strong profit margins on every seat.</p>
              </div>
              <div class="p-4 bg-slate-800/80 rounded-xl border border-slate-700">
                <i class="fa-solid fa-wallet text-accent text-xl mb-2"></i>
                <h4 class="font-bold text-sm">Prepaid Wallet & Invoicing</h4>
                <p class="text-xs text-slate-400 mt-1">Instant seat activation using BDT prepaid balance or bank transfers.</p>
              </div>
            </div>

            <div class="pt-4 flex flex-wrap gap-4">
              <a href="pages/reseller.html" class="bg-accent hover:bg-accent-dark text-white font-bold px-6 py-3 rounded-lg text-sm transition-all">Become a Reseller</a>
              <a href="dashboard/reseller.html" class="bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold px-6 py-3 rounded-lg text-sm border border-slate-700 transition-all">Preview Reseller Portal</a>
            </div>
          </div>

          <!-- Reseller Dashboard Mock Preview -->
          <div class="lg:col-span-6" data-aos="fade-left">
            <div class="bg-slate-800 rounded-2xl p-6 border border-slate-700 shadow-2xl">
              <div class="flex justify-between items-center pb-4 mb-4 border-b border-slate-700">
                <div>
                  <h4 class="font-bold text-sm">Reseller Partner Console</h4>
                  <p class="text-[11px] text-slate-400">Dhaka Tech Solutions Ltd. (Partner ID: BD-99201)</p>
                </div>
                <span class="text-xs bg-emerald-500/20 text-emerald-400 px-2.5 py-1 rounded-md font-mono">Tier 2 Distributor</span>
              </div>

              <!-- Reseller Metrics -->
              <div class="grid grid-cols-3 gap-3 mb-6">
                <div class="bg-slate-900/60 p-3 rounded-lg text-center border border-slate-700/50">
                  <span class="text-[10px] text-slate-400 uppercase font-semibold">Active Clients</span>
                  <p class="text-xl font-extrabold text-white mt-0.5">38</p>
                </div>
                <div class="bg-slate-900/60 p-3 rounded-lg text-center border border-slate-700/50">
                  <span class="text-[10px] text-slate-400 uppercase font-semibold">Total Seats</span>
                  <p class="text-xl font-extrabold text-white mt-0.5">412</p>
                </div>
                <div class="bg-slate-900/60 p-3 rounded-lg text-center border border-slate-700/50">
                  <span class="text-[10px] text-slate-400 uppercase font-semibold">Wallet BDT</span>
                  <p class="text-xl font-extrabold text-emerald-400 mt-0.5">৳142.5K</p>
                </div>
              </div>

              <!-- Client List Overview -->
              <div class="space-y-2">
                <p class="text-xs font-bold text-slate-400 uppercase">Recent Subscriptions Provisioned</p>
                <div class="bg-slate-900/40 p-3 rounded-lg flex justify-between items-center text-xs border border-slate-700/40">
                  <div>
                    <p class="font-bold text-white">Bengal Cyber Systems</p>
                    <p class="text-[10px] text-slate-400">25x M365 Business Standard</p>
                  </div>
                  <span class="text-emerald-400 font-mono font-bold">+৳3,750 Profit</span>
                </div>
                <div class="bg-slate-900/40 p-3 rounded-lg flex justify-between items-center text-xs border border-slate-700/40">
                  <div>
                    <p class="font-bold text-white">Chittagong Garments Corp</p>
                    <p class="text-[10px] text-slate-400">100x M365 Business Basic</p>
                  </div>
                  <span class="text-emerald-400 font-mono font-bold">+৳7,200 Profit</span>
                </div>
              </div>
            </div>
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
            <button onclick="toggleFaq(1)" class="w-full text-left p-5 font-bold text-brand-900 flex justify-between items-center gap-4 hover:bg-slate-50 min-h-[56px]">
              <span>How do I pay in Bangladeshi Taka (BDT)?</span>
              <i class="fa-solid fa-chevron-down text-slate-400 text-sm transition-transform duration-200" id="faq-icon-1"></i>
            </button>
            <div id="faq-answer-1" class="hidden px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
              We support local payment gateways including bKash Merchant, Nagad, Visa/Mastercard issued by Bangladeshi banks, and direct Electronic Fund Transfer (EFT) for enterprise billing. Official local VAT invoices are provided with every order.
            </div>
          </div>

          <!-- Item 2 -->
          <div class="bg-white rounded-xl border border-slate-200 overflow-hidden transition-all">
            <button onclick="toggleFaq(2)" class="w-full text-left p-5 font-bold text-brand-900 flex justify-between items-center gap-4 hover:bg-slate-50 min-h-[56px]">
              <span>How long does tenant provisioning take after payment?</span>
              <i class="fa-solid fa-chevron-down text-slate-400 text-sm transition-transform duration-200" id="faq-icon-2"></i>
            </button>
            <div id="faq-answer-2" class="hidden px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
              Existing Microsoft 365 tenants receive added license seats instantly via automated authorization. New tenant domain creations typically complete within 5 to 15 minutes after checkout confirmation.
            </div>
          </div>

          <!-- Item 3 -->
          <div class="bg-white rounded-xl border border-slate-200 overflow-hidden transition-all">
            <button onclick="toggleFaq(3)" class="w-full text-left p-5 font-bold text-brand-900 flex justify-between items-center gap-4 hover:bg-slate-50 min-h-[56px]">
              <span>Can I adjust license seat quantities mid-month?</span>
              <i class="fa-solid fa-chevron-down text-slate-400 text-sm transition-transform duration-200" id="faq-icon-3"></i>
            </button>
            <div id="faq-answer-3" class="hidden px-5 pb-5 text-sm text-slate-600 leading-relaxed border-t border-slate-100 pt-3">
              Yes, you can add or reduce licenses anytime through the CloudSync Customer Portal. Mid-cycle additions are prorated on a daily basis and billed to your next billing statement.
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
        <h2 class="text-3xl font-extrabold sm:text-4xl tracking-tight mb-4">Ready to Modernize Your Office Productivity?</h2>
        <p class="text-slate-300 text-base max-w-2xl mx-auto mb-8">Get started with transparent BDT pricing, localized billing support, and seamless deployment.</p>
        <div class="flex flex-col sm:flex-row justify-center gap-4">
          <a href="auth/register.html" class="bg-accent hover:bg-accent-dark text-white font-bold px-8 py-3.5 rounded-lg text-sm transition-all shadow-lg min-h-[48px] flex items-center justify-center">Create Account</a>
          <a href="pages/contact.html" class="bg-slate-800 hover:bg-slate-700 text-slate-200 font-bold px-8 py-3.5 rounded-lg text-sm border border-slate-700 transition-all min-h-[48px] flex items-center justify-center">Contact Local Engineers</a>
        </div>
      </div>
    </section>
  </main>

  <!-- ========================================== -->
  <!-- COMPONENT: FOOTER                          -->
  <!-- ========================================== -->
  <footer class="bg-brand-950 text-slate-400 text-xs border-t border-slate-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
      <div class="grid grid-cols-2 md:grid-cols-5 gap-8">

        <div class="col-span-2 space-y-4">
          <a href="index.html" class="flex items-center gap-2">
            <div class="w-8 h-8 bg-brand-500 rounded-md flex items-center justify-center text-white font-bold text-base">
              <i class="fa-solid me-0 fa-cubes"></i>
            </div>
            <span class="font-extrabold text-lg text-white tracking-tight">CloudSync</span>
          </a>
          <p class="text-slate-400 leading-relaxed max-w-sm">
            CloudSync is an independent enterprise software subscription management platform operated in Dhaka, Bangladesh. We provide subscription billing, licensing control, and reseller provisioning tools for Microsoft 365 services.
          </p>
          <div class="flex gap-4 text-slate-400 text-base">
            <a href="#" class="hover:text-white"><i class="fa-brands fa-linkedin"></i></a>
            <a href="#" class="hover:text-white"><i class="fa-brands fa-facebook"></i></a>
            <a href="#" class="hover:text-white"><i class="fa-brands fa-twitter"></i></a>
          </div>
        </div>

        <div>
          <p class="font-bold text-white uppercase tracking-wider mb-4">Products</p>
          <ul class="space-y-2.5">
            <li><a href="pages/business-basic.html" class="hover:text-white">Business Basic</a></li>
            <li><a href="pages/business-standard.html" class="hover:text-white">Business Standard</a></li>
            <li><a href="pages/business-premium.html" class="hover:text-white">Business Premium</a></li>
            <li><a href="pages/copilot.html" class="hover:text-white">Copilot for M365</a></li>
          </ul>
        </div>

        <div>
          <p class="font-bold text-white uppercase tracking-wider mb-4">Portals</p>
          <ul class="space-y-2.5">
            <li><a href="dashboard/customer.html" class="hover:text-white">Customer Console</a></li>
            <li><a href="dashboard/reseller.html" class="hover:text-white">Reseller Console</a></li>
            <li><a href="dashboard/admin-preview.html" class="hover:text-white">Admin Portal</a></li>
            <li><a href="checkout/provisioning.html" class="hover:text-white">Provisioning Engine</a></li>
          </ul>
        </div>

        <div>
          <p class="font-bold text-white uppercase tracking-wider mb-4">Legal & Support</p>
          <ul class="space-y-2.5">
            <li><a href="pages/faq.html" class="hover:text-white">FAQ</a></li>
            <li><a href="pages/contact.html" class="hover:text-white">Dhaka Support Center</a></li>
            <li><a href="#" class="hover:text-white">Privacy Policy</a></li>
            <li><a href="#" class="hover:text-white">Terms of Service</a></li>
          </ul>
        </div>

      </div>

      <div class="mt-12 pt-8 border-t border-slate-800/80 flex flex-col sm:flex-row justify-between items-center gap-4 text-slate-500">
        <p>© 2026 CloudSync Bangladesh. All rights reserved.</p>
        <p class="text-[11px]">Microsoft 365, Word, Excel, PowerPoint, Teams, and Azure are registered trademarks of Microsoft Corporation.</p>
      </div>
    </div>
  </footer>

  <!-- AOS Scripts -->
  <script src="https://unpkg.com/aos@next/dist/aos.js"></script>

  <!-- JavaScript Interactions -->
  <script>
    // Initialize Animate On Scroll
    AOS.init({ duration: 600, once: true, offset: 50 });

    // Mobile Menu Toggle
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileMenu = document.getElementById('mobile-menu');
    const menuIcon = document.getElementById('menu-icon');

    mobileMenuBtn.addEventListener('click', () => {
      mobileMenu.classList.toggle('hidden');
      if (mobileMenu.classList.contains('hidden')) {
        menuIcon.className = 'fa-solid fa-bars text-xl';
      } else {
        menuIcon.className = 'fa-solid fa-xmark text-xl';
      }
    });

    // Pricing Calculator Engine
    let currentCycle = 'monthly';
    const basePrices = {
      basic: { monthly: 720, annual: 610 },
      standard: { monthly: 1500, annual: 1280 },
      premium: { monthly: 2650, annual: 2250 }
    };

    function switchBilling(cycle) {
      currentCycle = cycle;
      const btnMonthly = document.getElementById('btn-monthly');
      const btnAnnual = document.getElementById('btn-annual');

      if (cycle === 'monthly') {
        btnMonthly.className = "px-5 py-2 text-xs sm:text-sm font-bold rounded-lg transition-all bg-white text-brand-900 shadow-sm";
        btnAnnual.className = "px-5 py-2 text-xs sm:text-sm font-bold rounded-lg transition-all text-slate-600 hover:text-brand-900 flex items-center gap-1.5";
      } else {
        btnAnnual.className = "px-5 py-2 text-xs sm:text-sm font-bold rounded-lg transition-all bg-white text-brand-900 shadow-sm flex items-center gap-1.5";
        btnMonthly.className = "px-5 py-2 text-xs sm:text-sm font-bold rounded-lg transition-all text-slate-600 hover:text-brand-900";
      }

      ['basic', 'standard', 'premium'].forEach(calculatePrice);
    }

    function adjustQty(plan, delta) {
      const input = document.getElementById(`qty-${plan}`);
      let currentVal = parseInt(input.value) || 1;
      currentVal = Math.max(1, currentVal + delta);
      input.value = currentVal;
      calculatePrice(plan);
    }

    function calculatePrice(plan) {
      const qtyInput = document.getElementById(`qty-${plan}`);
      const priceUnitEl = document.getElementById(`price-${plan}`);
      const totalEl = document.getElementById(`total-${plan}`);

      let qty = parseInt(qtyInput.value) || 1;
      if (qty < 1) { qty = 1; qtyInput.value = 1; }

      const unitPrice = basePrices[plan][currentCycle];
      const total = unitPrice * qty;

      priceUnitEl.innerText = `৳${unitPrice.toLocaleString()}`;
      totalEl.innerText = `৳${total.toLocaleString()} / mo`;
    }

    // FAQ Accordion Toggle
    function toggleFaq(id) {
      const answer = document.getElementById(`faq-answer-${id}`);
      const icon = document.getElementById(`faq-icon-${id}`);

      const isHidden = answer.classList.contains('hidden');

      // Close all answers first
      document.querySelectorAll('[id^="faq-answer-"]').forEach(el => el.classList.add('hidden'));
      document.querySelectorAll('[id^="faq-icon-"]').forEach(el => el.style.transform = 'rotate(0deg)');

      if (isHidden) {
        answer.classList.remove('hidden');
        icon.style.transform = 'rotate(180deg)';
      }
    }
  </script>
</body>
</html>


