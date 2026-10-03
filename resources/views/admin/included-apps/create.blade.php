@extends('layouts.admin.admin')

@section('title', 'Add New Included App | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('admin.included-apps.index') }}" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">Included Apps</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Add App</span>
@endsection

@section('content')

    <!-- Top Header -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                Add New Included App
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Create a new dynamic app card under the Productivity or Security tabs on the homepage.
            </p>
        </div>
        <a href="{{ route('admin.included-apps.index') }}" class="text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to List</span>
        </a>
    </div>

    <!-- Create Form Card -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-xs max-w-4xl">
        <form action="{{ route('admin.included-apps.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <!-- Form Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Category -->
                <div>
                    <label for="category" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Tab Category <span class="text-red-500">*</span>
                    </label>
                    <select id="category" name="category" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                        <option value="productivity" {{ old('category', request('category')) === 'productivity' ? 'selected' : '' }}>Productivity Apps</option>
                        <option value="security" {{ old('category', request('category')) === 'security' ? 'selected' : '' }}>Security & Storage Apps</option>
                    </select>
                    @error('category')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- App Name (Brand/App identifier) -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        App Name / Title <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Microsoft Copilot, Word, OneDrive" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Tagline / Subtitle -->
                <div class="md:col-span-2">
                    <label for="tagline" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Card Tagline / Headline <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="tagline" name="tagline" value="{{ old('tagline') }}" placeholder="e.g. Empower yourself with Copilot, 1 TB Secure Cloud Backup" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    @error('tagline')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Description -->
                <div class="md:col-span-2">
                    <label for="description" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Description <span class="text-red-500">*</span>
                    </label>
                    <textarea id="description" name="description" rows="3" placeholder="Provide a brief explanation of what this app does..." required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all leading-relaxed">{{ old('description') }}</textarea>
                    @error('description')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Link URL -->
                <div>
                    <label for="link_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Link URL
                    </label>
                    <input type="text" id="link_url" name="link_url" value="{{ old('link_url', '#plans') }}" placeholder="e.g. https://copilot.microsoft.com or #plans" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    @error('link_url')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Link Text -->
                <div>
                    <label for="link_text" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Link Text
                    </label>
                    <input type="text" id="link_text" name="link_text" value="{{ old('link_text', 'Learn more') }}" placeholder="e.g. Learn more, Get started" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    @error('link_text')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preset Icon Selector -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Choose Preset Microsoft Icon
                    </label>
                    <div class="grid grid-cols-4 sm:grid-cols-8 gap-2.5 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/80">
                        @php
                            $presetIcons = [
                                'assets/img/products/copilot.png' => 'Copilot',
                                'assets/img/products/word.png' => 'Word',
                                'assets/img/products/excel.png' => 'Excel',
                                'assets/img/products/powerpoint.png' => 'PowerPoint',
                                'assets/img/products/outlook.png' => 'Outlook',
                                'assets/img/products/teams.png' => 'Teams',
                                'assets/img/products/onedrive.png' => 'OneDrive',
                                'assets/img/products/defender.png' => 'Defender',
                                'assets/img/products/onenote.png' => 'OneNote',
                                'assets/img/products/clipchamp.png' => 'Clipchamp',
                                'assets/img/products/access.png' => 'Access',
                                'assets/img/products/publisher.png' => 'Publisher',
                                'assets/img/products/sharepoint.png' => 'SharePoint',
                                'assets/img/products/power-bi.png' => 'Power BI',
                                'assets/img/products/power-automate.png' => 'Power Automate',
                                'assets/img/products/power-apps.png' => 'Power Apps',
                            ];
                        @endphp
                        @foreach($presetIcons as $path => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="preset_icon" value="{{ $path }}" class="peer sr-only" {{ old('preset_icon') === $path ? 'checked' : '' }}>
                                <div class="p-2 rounded-xl border border-transparent peer-checked:border-[#0067b8] peer-checked:bg-white dark:peer-checked:bg-slate-800 peer-checked:shadow-sm hover:bg-white/60 dark:hover:bg-slate-800/60 transition-all flex flex-col items-center justify-center text-center">
                                    <img src="{{ asset($path) }}" alt="{{ $label }}" class="w-8 h-8 object-contain mb-1">
                                    <span class="text-[10px] font-semibold text-slate-700 dark:text-slate-300 truncate w-full">{{ $label }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Custom Icon Upload (Alternative) -->
                <div>
                    <label for="icon_image" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Or Upload Custom Icon Image (Optional)
                    </label>
                    <input type="file" id="icon_image" name="icon_image" accept="image/*" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#0067b8] file:text-white hover:file:bg-[#005a9e] cursor-pointer">
                    <p class="text-[11px] text-slate-400 mt-1">PNG, JPG, WebP or SVG with transparent background.</p>
                    @error('icon_image')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Sort Order -->
                <div>
                    <label for="sort_order" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Sort Order
                    </label>
                    <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', 0) }}" min="0" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    @error('sort_order')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Active Status -->
                <div class="md:col-span-2">
                    <label class="inline-flex items-center gap-2.5 cursor-pointer">
                        <input type="checkbox" name="is_active" value="1" {{ old('is_active', true) ? 'checked' : '' }} class="w-4 h-4 text-[#0067b8] rounded border-slate-300 dark:border-slate-700 focus:ring-[#0067b8]">
                        <span class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200">Active (Visible on homepage)</span>
                    </label>
                </div>

            </div>

            <!-- Submit Button -->
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.included-apps.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-6 py-2.5 rounded-xl text-xs sm:text-sm shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all active:scale-95 cursor-pointer">
                    Save App Card
                </button>
            </div>
        </form>
    </div>

@endsection
