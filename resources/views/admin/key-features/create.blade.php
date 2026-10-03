@extends('layouts.admin.admin')

@section('title', 'Add New Key Feature | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('admin.key-features.index') }}" class="text-slate-500 dark:text-slate-400 hover:text-[#0067b8]">
        Key Features
    </a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        Add New Feature
    </span>
@endsection

@section('content')

    <!-- Header -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                Add New Key Feature Card
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Configure the feature card's title, description, badge icon, link, and illustration image.
            </p>
        </div>
        <a href="{{ route('admin.key-features.index') }}" class="text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 px-4 py-2.5 rounded-xl transition-colors flex items-center gap-1.5 cursor-pointer">
            <i class="fa-solid fa-arrow-left text-[11px]"></i>
            <span>Back to List</span>
        </a>
    </div>

    <!-- Form Card -->
    <div class="max-w-4xl bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-xs">
        <form action="{{ route('admin.key-features.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Validation Errors Alert -->
            @if ($errors->any())
                <div class="bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-900/50 rounded-2xl p-4 text-red-700 dark:text-red-400 text-xs">
                    <p class="font-bold mb-1"><i class="fa-solid fa-circle-exclamation mr-1"></i> Please fix the following errors:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Feature Title -->
                <div class="md:col-span-2">
                    <label for="title" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Card Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required placeholder="e.g. AI-powered productivity" class="w-full bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea name="description" id="description" rows="3" required placeholder="e.g. Get real-time assistance with Microsoft 365 Copilot to create, summarize, analyze, and more." class="w-full bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl p-4 text-xs sm:text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all resize-none">{{ old('description') }}</textarea>
                </div>

                <!-- Icon Class -->
                <div>
                    <label for="icon" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        FontAwesome Icon Class <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <input type="text" name="icon" id="icon" value="{{ old('icon', 'fa-solid fa-wand-magic-sparkles') }}" required placeholder="fa-solid fa-wand-magic-sparkles" class="w-full bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl pl-11 pr-4 py-3 text-xs sm:text-sm font-mono text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        <div class="absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400">
                            <i id="icon-preview" class="fa-solid fa-wand-magic-sparkles text-sm"></i>
                        </div>
                    </div>
                    <p class="text-[10px] text-slate-400 mt-1">Example: <code class="bg-slate-100 dark:bg-slate-800 px-1 py-0.5 rounded">fa-solid fa-cloud</code>, <code class="bg-slate-100 dark:bg-slate-800 px-1 py-0.5 rounded">fa-solid fa-users</code>, <code class="bg-slate-100 dark:bg-slate-800 px-1 py-0.5 rounded">fa-solid fa-shield-halved</code></p>
                </div>

                <!-- Icon Background Color -->
                <div>
                    <label for="icon_bg_color" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Icon Color Theme <span class="text-red-500">*</span>
                    </label>
                    <select name="icon_bg_color" id="icon_bg_color" class="w-full bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all cursor-pointer">
                        <option value="purple" {{ old('icon_bg_color') == 'purple' ? 'selected' : '' }}>Purple (AI Copilot)</option>
                        <option value="sky" {{ old('icon_bg_color') == 'sky' ? 'selected' : '' }}>Sky Blue (OneDrive Cloud)</option>
                        <option value="indigo" {{ old('icon_bg_color') == 'indigo' ? 'selected' : '' }}>Indigo (Teams Collaboration)</option>
                        <option value="blue" {{ old('icon_bg_color') == 'blue' ? 'selected' : '' }}>Blue (Security & Defender)</option>
                        <option value="emerald" {{ old('icon_bg_color') == 'emerald' ? 'selected' : '' }}>Emerald (Green)</option>
                        <option value="amber" {{ old('icon_bg_color') == 'amber' ? 'selected' : '' }}>Amber (Orange/Gold)</option>
                        <option value="rose" {{ old('icon_bg_color') == 'rose' ? 'selected' : '' }}>Rose (Red/Pink)</option>
                    </select>
                </div>

                <!-- Link Text -->
                <div>
                    <label for="link_text" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Link Anchor Text
                    </label>
                    <input type="text" name="link_text" id="link_text" value="{{ old('link_text', 'Learn more') }}" placeholder="Learn more" class="w-full bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs sm:text-sm text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                </div>

                <!-- Link URL -->
                <div>
                    <label for="link_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Link Target URL
                    </label>
                    <input type="text" name="link_url" id="link_url" value="{{ old('link_url', '#plans') }}" placeholder="#plans" class="w-full bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs sm:text-sm font-mono text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                </div>

                <!-- Image Upload or Existing Selection -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Feature Image / UI Graphic
                    </label>
                    
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <!-- Option A: Upload New Image -->
                        <div class="border border-dashed border-slate-300 dark:border-slate-700 rounded-2xl p-5 text-center bg-slate-50/50 dark:bg-slate-800/40">
                            <i class="fa-solid fa-cloud-arrow-up text-2xl text-slate-400 mb-2"></i>
                            <p class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Upload New Image File</p>
                            <p class="text-[10px] text-slate-400 mb-3">PNG, JPG, WEBP (Max 4MB)</p>
                            <input type="file" name="image" id="image" accept="image/*" class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0067b8] file:text-white hover:file:bg-[#005a9e] cursor-pointer">
                        </div>

                        <!-- Option B: Select from Existing Preset Graphics -->
                        <div class="border border-slate-200 dark:border-slate-700 rounded-2xl p-5 bg-slate-50/50 dark:bg-slate-800/40 flex flex-col justify-between">
                            <div>
                                <p class="text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Or Pick Existing Preset Asset</p>
                                <p class="text-[10px] text-slate-400 mb-3">Select from bundled Microsoft graphics</p>
                                <select name="image_select" id="image_select" class="w-full bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 rounded-xl px-3 py-2 text-xs text-slate-700 dark:text-slate-300">
                                    <option value="">-- Do not use preset --</option>
                                    <option value="assets/img/key-feature/Learn More_ Create a Presentation.png">Presentation AI Copilot UI</option>
                                    <option value="assets/img/key-feature/Cloud Storage Dashboard Illustration.png">Cloud Storage OneDrive UI</option>
                                    <option value="assets/img/key-feature/Soft Teams Dashboard Illustration.png">Teams Collaboration UI</option>
                                    <option value="assets/img/key-feature/Cloud Security Shield Illustration.png">Security Shield Illustration</option>
                                    <option value="assets/img/key-feature/Minimalist Neumorphic Dashboard UI.png">Planner & Task Dashboard</option>
                                    <option value="assets/img/key-feature/Pastel Futuristic Analytics Dashboard.png">Power BI Analytics Dashboard</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Sort Order Position
                    </label>
                    <input type="number" name="sort_order" id="sort_order" value="{{ old('sort_order', 1) }}" min="0" class="w-full bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-xl px-4 py-3 text-xs sm:text-sm font-semibold text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                </div>

                <!-- Active Status Toggle -->
                <div class="flex items-center gap-3 pt-6">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="sr-only peer">
                        <div class="w-11 h-6 bg-slate-200 peer-focus:outline-none rounded-full peer dark:bg-slate-700 peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all dark:border-slate-600 peer-checked:bg-[#0067b8]"></div>
                        <span class="ml-3 text-xs font-bold text-slate-800 dark:text-slate-200">Card is Active & Visible</span>
                    </label>
                </div>

            </div>

            <!-- Submit Button -->
            <div class="pt-6 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.key-features.index') }}" class="px-5 py-3 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-6 py-3 rounded-xl text-xs sm:text-sm flex items-center gap-2 shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all active:scale-95 cursor-pointer">
                    <i class="fa-solid fa-check text-xs"></i>
                    <span>Save Key Feature</span>
                </button>
            </div>

        </form>
    </div>

@endsection

@push('scripts')
<script>
    const iconInput = document.getElementById('icon');
    const iconPreview = document.getElementById('icon-preview');

    if (iconInput && iconPreview) {
        iconInput.addEventListener('input', function() {
            iconPreview.className = this.value + ' text-sm';
        });
    }
</script>
@endpush
