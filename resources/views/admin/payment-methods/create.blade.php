@extends('layouts.admin.admin')

@section('title', 'Add Payment Method | Admin Control Center')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0067b8] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('admin.payment-methods.index') }}" class="hover:text-[#0067b8] transition-colors">Payment Methods</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 dark:text-slate-200">Add Method</span>
    </div>
@endsection

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Flash Errors -->
    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/80 text-red-800 dark:text-red-300 shadow-xs">
            <div class="flex items-center gap-3 mb-1">
                <i class="fa-solid fa-circle-exclamation text-red-500 text-lg"></i>
                <p class="text-xs sm:text-sm font-bold">Please correct the following errors:</p>
            </div>
            <ul class="list-disc list-inside text-xs space-y-0.5 ml-6">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <span class="w-10 h-10 rounded-2xl bg-[#0067b8]/10 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-lg shadow-xs">
                    <i class="fa-solid fa-credit-card"></i>
                </span>
                <span>Add New Payment Method</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Select a predefined driver slug from your <code class="font-mono text-xs bg-slate-100 dark:bg-slate-800 px-1 py-0.5 rounded">.env</code> configuration and configure its display details.
            </p>
        </div>

        <a href="{{ route('admin.payment-methods.index') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
            <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to List
        </a>
    </div>

    <!-- Form Card -->
    <form action="{{ route('admin.payment-methods.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs space-y-5">
            
            <div class="border-b border-slate-100 dark:border-slate-800 pb-3">
                <h3 class="text-sm font-black text-slate-900 dark:text-white uppercase tracking-wider flex items-center gap-2">
                    <i class="fa-solid fa-sliders text-[#0067b8] dark:text-sky-400"></i>
                    Method Configuration
                </h3>
            </div>

            <!-- Slug Selection (Dropdown from .env) -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                    Payment Driver / Gateway Slug <span class="text-red-500">*</span>
                </label>
                <div class="relative">
                    <select name="slug" id="slugSelect" required onchange="handleSlugChange(this)"
                            class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs font-mono font-bold text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all cursor-pointer">
                        <option value="" disabled {{ old('slug') ? '' : 'selected' }}>-- Select Predefined Payment Driver from .env --</option>
                        @foreach($availableMethods as $slugKey => $slugName)
                            <option value="{{ $slugKey }}" data-label="{{ $slugName }}" {{ old('slug') === $slugKey ? 'selected' : '' }}>
                                {{ $slugName }} (slug: {{ $slugKey }})
                            </option>
                        @endforeach
                    </select>
                </div>
                <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1.5 flex items-center gap-1.5">
                    <i class="fa-solid fa-circle-info text-blue-500"></i>
                    <span>This dropdown is populated dynamically from <strong class="text-slate-700 dark:text-slate-300">Available_Payment_Mehtod / AVAILABLE_PAYMENT_METHODS</strong> in <code class="font-mono text-[10px]">.env</code>.</span>
                </p>
            </div>

            <!-- Display Name -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                    Public Display Name <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="name" 
                       id="nameInput"
                       value="{{ old('name') }}" 
                       required 
                       placeholder="e.g. bKash Online, Nagad Personal, MoneyBag" 
                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">
                <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">This name is shown to users on checkout and payment pages.</p>
            </div>

            <!-- Logo Upload & Preview -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                    Payment Gateway Logo / Icon <span class="text-slate-400 text-[10px] font-normal">(Optional)</span>
                </label>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- File Upload Input -->
                    <div>
                        <input type="file" 
                               name="logo" 
                               id="logoFileInput"
                               accept="image/png,image/jpeg,image/svg+xml,image/webp" 
                               onchange="previewLogo(this)"
                               class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0067b8] file:text-white hover:file:bg-[#005a9e] file:cursor-pointer">
                        <p class="text-[10px] text-slate-400 mt-1">PNG, JPG, SVG, WebP (Max 2MB)</p>
                    </div>

                    <!-- Direct Logo URL (Alternative) -->
                    <div>
                        <input type="text" 
                               name="logo_url" 
                               id="logoUrlInput"
                               value="{{ old('logo_url') }}" 
                               oninput="previewUrlLogo(this.value)"
                               placeholder="Or enter logo Image URL..." 
                               class="w-full px-3.5 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">
                    </div>
                </div>

                <!-- Preview Box -->
                <div id="previewBox" class="mt-3 hidden items-center gap-3 p-3 bg-slate-50 dark:bg-slate-800/60 rounded-2xl border border-slate-200 dark:border-slate-700 w-fit">
                    <img id="logoPreviewImg" src="" alt="Logo Preview" class="h-10 w-auto object-contain max-w-[120px]">
                    <span class="text-xs text-slate-500 font-semibold">Live Logo Preview</span>
                </div>
            </div>

            <!-- API & Gateway Credentials Settings -->
            <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-200 dark:border-slate-700/80 space-y-4">
                <div class="flex items-center justify-between pb-2 border-b border-slate-200 dark:border-slate-700">
                    <h4 class="text-xs font-black uppercase tracking-wider text-[#0067b8] dark:text-sky-400 flex items-center gap-2">
                        <i class="fa-solid fa-key"></i>
                        <span>API & Gateway Credentials (Dynamic DB Configuration)</span>
                    </h4>
                    <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-blue-100 dark:bg-blue-900/40 text-[#0067b8] dark:text-sky-300">Saved directly to DB</span>
                </div>
                <p class="text-[11px] text-slate-500 dark:text-slate-400">
                    Enter API credentials here (e.g. for Moneybag or other automated gateways). The checkout flow reads directly from the database.
                </p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <!-- Base URL -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            API Base URL (e.g. Moneybag / Gateway Base Endpoint)
                        </label>
                        <input type="text" 
                               name="base_url" 
                               value="{{ old('base_url') }}" 
                               placeholder="https://api.moneybag.com.bd/api/v2" 
                               class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-mono text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                    </div>

                    <!-- Merchant Key -->
                    <div class="sm:col-span-2">
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            Merchant API Key / API Key
                        </label>
                        <input type="password" 
                               name="merchant_key" 
                               id="merchant_key"
                               value="{{ old('merchant_key') }}" 
                               placeholder="Enter your Merchant Key" 
                               class="w-full px-3.5 py-2.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-mono text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                        <div class="flex items-center justify-between mt-1">
                            <span class="text-[10px] text-slate-400">Used in <code class="font-mono text-[9px]">X-Merchant-API-Key</code> request headers.</span>
                            <button type="button" onclick="togglePasswordVisibility('merchant_key')" class="text-[10px] text-[#0067b8] hover:underline font-semibold cursor-pointer">Show / Hide Key</button>
                        </div>
                    </div>

                    <!-- Environment Mode -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            Environment Mode
                        </label>
                        <select name="mode" class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                            <option value="live" {{ old('mode', 'live') === 'live' ? 'selected' : '' }}>Live (Production)</option>
                            <option value="sandbox" {{ old('mode') === 'sandbox' ? 'selected' : '' }}>Sandbox (Test)</option>
                        </select>
                    </div>

                    <!-- API Secret (Optional) -->
                    <div>
                        <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">
                            API Secret / Password <span class="text-slate-400 text-[10px] font-normal">(Optional)</span>
                        </label>
                        <input type="password" 
                               name="api_secret" 
                               value="{{ old('api_secret') }}" 
                               placeholder="Secret or Private Key if required" 
                               class="w-full px-3.5 py-2 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-mono text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                    </div>
                </div>
            </div>

            <!-- Checkout Instructions -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                    Customer Instructions / Notes <span class="text-slate-400 text-[10px] font-normal">(Optional)</span>
                </label>
                <textarea name="instruction" 
                          rows="3" 
                          placeholder="e.g. Please send the total amount to personal bKash number 017xxxxxxxx and enter your transaction ID." 
                          class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">{{ old('instruction') }}</textarea>
            </div>

            <!-- Sort Order & Active Status -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5 pt-2">
                <!-- Sort Order -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Display Sort Order
                    </label>
                    <input type="number" 
                           name="sort_order" 
                           value="{{ old('sort_order', 0) }}" 
                           min="0"
                           class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">
                    <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-1">Lower numbers appear first on checkout.</p>
                </div>

                <!-- Active Toggle Switch -->
                <div class="flex items-center justify-between p-3.5 bg-slate-50 dark:bg-slate-800/60 rounded-2xl border border-slate-200/80 dark:border-slate-700/80 self-end">
                    <div>
                        <p class="text-xs font-bold text-slate-800 dark:text-slate-200">Active on Checkout</p>
                        <p class="text-[10px] text-slate-400">Enable for instant payments</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="status" value="1" {{ old('status', '1') ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-[#0067b8]"></div>
                    </label>
                </div>
            </div>

        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.payment-methods.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-7 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white text-xs sm:text-sm font-bold shadow-md shadow-[#0067b8]/25 active:scale-95 transition-all cursor-pointer flex items-center gap-2">
                <i class="fa-solid fa-check text-xs"></i>
                <span>Save Payment Method</span>
            </button>
        </div>

    </form>

</div>

<script>
    function handleSlugChange(select) {
        const selectedOption = select.options[select.selectedIndex];
        const label = selectedOption.getAttribute('data-label');
        const nameInput = document.getElementById('nameInput');

        if (label && (!nameInput.value || nameInput.value.trim() === '')) {
            nameInput.value = label;
        }
    }

    function previewLogo(input) {
        if (input.files && input.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                const previewImg = document.getElementById('logoPreviewImg');
                previewImg.src = e.target.result;
                document.getElementById('previewBox').classList.remove('hidden');
                document.getElementById('previewBox').classList.add('flex');
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function previewUrlLogo(url) {
        if (url && url.trim().startsWith('http')) {
            const previewImg = document.getElementById('logoPreviewImg');
            previewImg.src = url.trim();
            document.getElementById('previewBox').classList.remove('hidden');
            document.getElementById('previewBox').classList.add('flex');
        }
    }

    function togglePasswordVisibility(inputId) {
        const input = document.getElementById(inputId);
        if (input) {
            input.type = input.type === 'password' ? 'text' : 'password';
        }
    }
</script>
@endsection

