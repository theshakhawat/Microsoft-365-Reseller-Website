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

  @stack('js')

</body>
</html>


