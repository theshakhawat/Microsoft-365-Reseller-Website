<footer class="bg-white dark:bg-slate-950 text-slate-600 dark:text-slate-400 text-xs border-t border-slate-200/90 dark:border-slate-800/80 relative transition-colors duration-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-12 lg:py-16">
        <div class="grid grid-cols-2 md:grid-cols-5 gap-8 lg:gap-12">

            <!-- Col 1: Brand & Bio -->
            <div class="col-span-2 space-y-4">
                <a href="{{ url('/') }}" class="inline-block">
                    <img class="h-10 sm:h-12 w-auto object-contain" src="{{ site_file_url('footer_logo', 'assets/img/Microsoft Office Club Logo.png') }}" alt="{{ site_setting('site_name', 'Microsoft Office Club') }}" />
                </a>
                <p class="text-slate-600 dark:text-slate-400 text-xs leading-relaxed max-w-sm">
                    {!! nl2br(e(site_setting('footer_about_text', 'Authorized Microsoft 365 cloud subscription provider in Bangladesh. Genuine cloud licensing, automated activation, local BDT checkout with bKash & Nagad, and 24/7 dedicated support.'))) !!}
                </p>

                <!-- Accepted Payment Badges -->
                @php
                    $paymentMethodsList = array_filter(array_map('trim', explode(',', site_setting('accepted_payment_methods_text', 'bKash (Personal & Merchant), Nagad, Visa / Mastercard / AMEX'))));
                @endphp
                @if(count($paymentMethodsList) > 0)
                <div class="pt-2">
                    <p class="text-[11px] font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">Accepted Payment Methods</p>
                    <div class="flex flex-wrap items-center gap-2">
                        @foreach($paymentMethodsList as $methodName)
                            @php $methodLower = strtolower($methodName); @endphp
                            @if(str_contains($methodLower, 'bkash'))
                                <span class="bg-pink-50 dark:bg-pink-950/70 border border-pink-200 dark:border-pink-700/50 text-pink-700 dark:text-pink-300 px-2.5 py-1 rounded text-[11px] font-bold flex items-center gap-1.5 shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-pink-500 dark:bg-pink-400"></span> {{ $methodName }}
                                </span>
                            @elseif(str_contains($methodLower, 'nagad'))
                                <span class="bg-orange-50 dark:bg-orange-950/70 border border-orange-200 dark:border-orange-700/50 text-orange-700 dark:text-orange-300 px-2.5 py-1 rounded text-[11px] font-bold flex items-center gap-1.5 shadow-2xs">
                                    <span class="w-1.5 h-1.5 rounded-full bg-orange-500 dark:bg-orange-400"></span> {{ $methodName }}
                                </span>
                            @else
                                <span class="bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 px-2.5 py-1 rounded text-[11px] font-semibold shadow-2xs">
                                    {{ $methodName }}
                                </span>
                            @endif
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- Social Links -->
                <div class="flex items-center gap-3 text-slate-500 dark:text-slate-400 pt-2">
                    @if(site_setting('social_whatsapp', 'https://wa.me/' . site_setting('whatsapp_raw_number', '8801342325558')))
                    <a href="{{ site_setting('social_whatsapp', 'https://wa.me/' . site_setting('whatsapp_raw_number', '8801342325558')) }}" target="_blank" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 hover:bg-emerald-600 dark:hover:bg-emerald-600 hover:text-white dark:hover:text-white flex items-center justify-center transition-all shadow-2xs" title="WhatsApp"><i class="fa-brands fa-whatsapp text-xs"></i></a>
                    @endif
                    @if(site_setting('social_facebook'))
                    <a href="{{ site_setting('social_facebook') }}" target="_blank" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 hover:bg-[#0067b8] dark:hover:bg-[#0067b8] hover:text-white dark:hover:text-white flex items-center justify-center transition-all shadow-2xs" title="Facebook"><i class="fa-brands fa-facebook-f text-xs"></i></a>
                    @endif
                    @if(site_setting('social_linkedin'))
                    <a href="{{ site_setting('social_linkedin') }}" target="_blank" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 hover:bg-[#0077b5] dark:hover:bg-[#0077b5] hover:text-white dark:hover:text-white flex items-center justify-center transition-all shadow-2xs" title="LinkedIn"><i class="fa-brands fa-linkedin-in text-xs"></i></a>
                    @endif
                    @if(site_setting('social_twitter'))
                    <a href="{{ site_setting('social_twitter') }}" target="_blank" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 hover:bg-slate-900 dark:hover:bg-slate-700 hover:text-white dark:hover:text-white flex items-center justify-center transition-all shadow-2xs" title="Twitter / X"><i class="fa-brands fa-x-twitter text-xs"></i></a>
                    @endif
                    @if(site_setting('social_youtube'))
                    <a href="{{ site_setting('social_youtube') }}" target="_blank" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 hover:bg-red-600 dark:hover:bg-red-600 hover:text-white dark:hover:text-white flex items-center justify-center transition-all shadow-2xs" title="YouTube"><i class="fa-brands fa-youtube text-xs"></i></a>
                    @endif
                    @if(site_setting('social_instagram'))
                    <a href="{{ site_setting('social_instagram') }}" target="_blank" class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-900 border border-slate-200/80 dark:border-slate-800 hover:bg-pink-600 dark:hover:bg-pink-600 hover:text-white dark:hover:text-white flex items-center justify-center transition-all shadow-2xs" title="Instagram"><i class="fa-brands fa-instagram text-xs"></i></a>
                    @endif
                </div>
            </div>

            <!-- Col 2: Products & Plans -->
            <div>
                <p class="font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 text-xs">Plans & Apps</p>
                <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-400">
                    <li><a href="#plans" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">Microsoft 365 Basic</a></li>
                    <li><a href="#plans" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">Microsoft 365 Personal</a></li>
                    <li><a href="#included-apps" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">Word, Excel, PowerPoint</a></li>
                    <li><a href="#included-apps" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">1 TB OneDrive Cloud Storage</a></li>
                    <li><a href="#included-apps" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">Microsoft Defender Security</a></li>
                    <li><a href="#copilot-showcase" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">Copilot AI Integration</a></li>
                </ul>
            </div>

            <!-- Col 3: Quick Navigation -->
            <div>
                <p class="font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 text-xs">Quick Links</p>
                <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-400">
                    <li><a href="#copilot-showcase" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">Copilot AI Prompts</a></li>
                    <li><a href="#ai-features" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">Smart AI Capabilities</a></li>
                    <li><a href="#more-benefits" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">Explore Benefits</a></li>
                    <li><a href="#how-it-works" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">How It Works (4 Steps)</a></li>
                    <li><a href="#faq" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">Frequently Asked Questions</a></li>
                    <li><a href="#contact-support" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">Support & Inquiries</a></li>
                </ul>
            </div>

            <!-- Col 4: Support & Contact -->
            <div>
                <p class="font-bold text-slate-900 dark:text-white uppercase tracking-wider mb-4 text-xs">Customer Support</p>
                <ul class="space-y-2.5 text-xs text-slate-600 dark:text-slate-400">
                    @if(site_setting('contact_address'))
                    <li class="flex items-start gap-2">
                        <i class="fa-solid fa-location-dot text-[#0067b8] dark:text-sky-400 mt-0.5"></i>
                        <span>{{ site_setting('contact_address', 'Gulshan-2 / Motijheel, Dhaka, Bangladesh') }}</span>
                    </li>
                    @endif
                    @if(site_setting('whatsapp_number'))
                    <li class="flex items-center gap-2">
                        <i class="fa-brands fa-whatsapp text-emerald-600 dark:text-emerald-400"></i>
                        <a href="https://wa.me/{{ site_setting('whatsapp_raw_number', '8801342325558') }}?text={{ urlencode(site_setting('whatsapp_chat_message', 'Hello I want to order Microsoft 365 Subscription')) }}" target="_blank" class="hover:text-[#0067b8] dark:hover:text-white transition-colors">{{ site_setting('whatsapp_number', '+880 1342-325558') }}</a>
                    </li>
                    @endif
                    @if(site_setting('contact_phone'))
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-phone text-[#0067b8] dark:text-sky-400"></i>
                        <a href="tel:{{ site_setting('contact_phone_raw', '+88096490123756') }}" class="hover:text-[#0067b8] dark:hover:text-white transition-colors">{{ site_setting('contact_phone', '09649-0123756') }}</a>
                    </li>
                    @endif
                    @if(site_setting('contact_email'))
                    <li class="flex items-center gap-2">
                        <i class="fa-solid fa-envelope text-slate-500 dark:text-slate-400"></i>
                        <a href="mailto:{{ site_setting('contact_email') }}" class="hover:text-[#0067b8] dark:hover:text-white transition-colors">{{ site_setting('contact_email', 'support@cloudsync.com.bd') }}</a>
                    </li>
                    @endif
                    @if(site_setting('support_status_badge'))
                    <li class="pt-2">
                        <span class="inline-flex items-center gap-1.5 bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800/50 text-emerald-700 dark:text-emerald-400 px-2 py-0.5 rounded text-[10px] font-semibold shadow-2xs">
                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500 dark:bg-emerald-400 animate-pulse"></span> {{ site_setting('support_status_badge', 'Support Available 24/7') }}
                        </span>
                    </li>
                    @endif
                </ul>
            </div>

        </div>

        <!-- Bottom Disclaimer & Trademark -->
        <div class="mt-12 pt-8 border-t border-slate-200/90 dark:border-slate-800/80 flex flex-col md:flex-row justify-between items-center gap-4 text-slate-500 dark:text-slate-400 text-[11px]">
            <div class="flex items-center gap-2">
                <div class="grid grid-cols-2 gap-0.5 w-3 h-3 shrink-0 opacity-80">
                    <div class="bg-[#f25022]"></div>
                    <div class="bg-[#7fba00]"></div>
                    <div class="bg-[#00a4ef]"></div>
                    <div class="bg-[#ffb900]"></div>
                </div>
                <p>{{ site_setting('footer_copyright_text', '© 2026 Microsoft 365 Reseller Bangladesh. All rights reserved.') }}</p>
            </div>
            <p class="text-center md:text-right max-w-xl text-slate-500 dark:text-slate-400 leading-relaxed">
                {{ site_setting('footer_disclaimer_text', 'Microsoft, Microsoft 365, Office 365, Word, Excel, PowerPoint, Outlook, Teams, OneDrive, and Copilot are registered trademarks of Microsoft Corporation. We are an authorized cloud solution provider & reseller.') }}
            </p>
        </div>
    </div>

    <!-- Floating WhatsApp & Support Button -->
    @if(site_is_enabled('floating_whatsapp_enabled', true))
    <aside aria-label="Support contacts" class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3">
        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" id="back-to-top" class="w-10 h-10 rounded-full bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-white shadow-lg border border-slate-200 dark:border-slate-700 flex items-center justify-center transition-all opacity-0 pointer-events-none cursor-pointer" title="Back to top">
            <i class="fa-solid fa-arrow-up text-xs"></i>
        </button>
        <a href="https://wa.me/{{ site_setting('whatsapp_raw_number', '8801342325558') }}?text={{ urlencode(site_setting('whatsapp_chat_message', 'Hello I want to order Microsoft 365 Subscription')) }}" target="_blank" class="bg-emerald-600 hover:bg-emerald-500 text-white font-bold px-4 py-2.5 rounded-full shadow-2xl flex items-center gap-2.5 transition-all hover:scale-105 group border border-emerald-400/30">
            <i class="fa-brands fa-whatsapp text-xl"></i>
            <span class="text-xs font-bold tracking-wide">{{ site_setting('floating_whatsapp_button_text', 'WhatsApp Support') }}</span>
            <span class="w-2 h-2 rounded-full bg-emerald-200 animate-ping"></span>
        </a>
    </aside>
    @else
    <aside aria-label="Support contacts" class="fixed bottom-6 right-6 z-50 flex flex-col items-end gap-3">
        <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})" id="back-to-top" class="w-10 h-10 rounded-full bg-white dark:bg-slate-800 hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-700 dark:text-white shadow-lg border border-slate-200 dark:border-slate-700 flex items-center justify-center transition-all opacity-0 pointer-events-none cursor-pointer" title="Back to top">
            <i class="fa-solid fa-arrow-up text-xs"></i>
        </button>
    </aside>
    @endif
</footer>

<!-- jQuery & Owl Carousel JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

<!-- AOS Scripts -->
<script src="https://unpkg.com/aos@next/dist/aos.js"></script>

<!-- Scripts -->
<script>
    // Initialize Animate On Scroll
    if (typeof AOS !== 'undefined') {
        AOS.init({
            duration: 600
            , once: true
            , offset: 40
        });
    }

    // Back to Top Button
    const backToTopBtn = document.getElementById('back-to-top');
    window.addEventListener('scroll', () => {
        if (window.scrollY > 400) {
            backToTopBtn.classList.remove('opacity-0', 'pointer-events-none');
            backToTopBtn.classList.add('opacity-100');
        } else {
            backToTopBtn.classList.add('opacity-0', 'pointer-events-none');
            backToTopBtn.classList.remove('opacity-100');
        }
    });

    // Mobile Off-Canvas Sidebar Controller
    const mobileMenuBtn = document.getElementById('mobile-menu-btn');
    const mobileSidebarClose = document.getElementById('mobile-sidebar-close');
    const mobileSidebar = document.getElementById('mobile-sidebar');
    const mobileBackdrop = document.getElementById('mobile-menu-backdrop');
    const mobileNavLinks = document.querySelectorAll('.mobile-nav-link');

    function openMobileSidebar() {
        if (mobileSidebar && mobileBackdrop) {
            mobileSidebar.classList.remove('translate-x-full');
            mobileSidebar.classList.add('translate-x-0');
            mobileBackdrop.classList.remove('opacity-0', 'pointer-events-none');
            mobileBackdrop.classList.add('opacity-100', 'pointer-events-auto');
            document.body.style.overflow = 'hidden';
        }
    }

    function closeMobileSidebar() {
        if (mobileSidebar && mobileBackdrop) {
            mobileSidebar.classList.remove('translate-x-0');
            mobileSidebar.classList.add('translate-x-full');
            mobileBackdrop.classList.remove('opacity-100', 'pointer-events-auto');
            mobileBackdrop.classList.add('opacity-0', 'pointer-events-none');
            document.body.style.overflow = '';
        }
    }

    if (mobileMenuBtn) {
        mobileMenuBtn.addEventListener('click', openMobileSidebar);
    }

    if (mobileSidebarClose) {
        mobileSidebarClose.addEventListener('click', closeMobileSidebar);
    }

    if (mobileBackdrop) {
        mobileBackdrop.addEventListener('click', closeMobileSidebar);
    }

    // Dark Mode Toggle Logic
    function toggleDarkMode() {
        const isDark = document.documentElement.classList.contains('dark');
        if (isDark) {
            document.documentElement.classList.remove('dark');
            localStorage.setItem('theme', 'light');
        } else {
            document.documentElement.classList.add('dark');
            localStorage.setItem('theme', 'dark');
        }
    }

    // Auto-close drawer when any link is clicked
    if (mobileNavLinks) {
        mobileNavLinks.forEach(link => {
            link.addEventListener('click', () => {
                closeMobileSidebar();
            });
        });
    }

</script>

@stack('js')

{!! site_setting('custom_footer_scripts') !!}

</body>
</html>
