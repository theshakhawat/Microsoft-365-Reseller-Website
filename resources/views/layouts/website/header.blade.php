<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>@yield('title', "CloudSync | Microsoft 365 Reseller & Subscription Management Platform Bangladesh")</title>
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

    @stack('css')

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
