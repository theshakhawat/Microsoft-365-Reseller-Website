@extends('layouts.admin.admin')

@section('title', 'Add New Trusted Brand | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('admin.trusted-brands.index') }}" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">Trusted Brands</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Add Brand</span>
@endsection

@section('content')

    <!-- Top Header -->
    <div class="flex items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                Add New Trusted Brand
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Add a new client/partner brand logo for the "Trusted by millions around the world" section.
            </p>
        </div>
        <a href="{{ route('admin.trusted-brands.index') }}" class="text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex items-center gap-1.5">
            <i class="fa-solid fa-arrow-left text-xs"></i>
            <span>Back to List</span>
        </a>
    </div>

    <!-- Create Form Card -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-xs max-w-3xl">
        <form action="{{ route('admin.trusted-brands.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

                <!-- Brand Name -->
                <div>
                    <label for="name" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Brand Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="e.g. Coca-Cola, Toyota, Nike" required class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    @error('name')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Website URL -->
                <div>
                    <label for="website_url" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Website URL (Optional)
                    </label>
                    <input type="url" id="website_url" name="website_url" value="{{ old('website_url') }}" placeholder="https://example.com" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-900 dark:text-white text-xs sm:text-sm focus:ring-2 focus:ring-[#0067b8] focus:border-transparent outline-none transition-all">
                    @error('website_url')
                        <p class="text-red-500 text-xs mt-1 font-semibold">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Preset Logos Selector -->
                <div class="md:col-span-2">
                    <label class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Select Preset Brand Logo
                    </label>
                    <div class="grid grid-cols-3 sm:grid-cols-5 gap-3 p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700/80">
                        @php
                            $presetBrands = [
                                'assets/img/brands/coca-cola.svg' => 'Coca-Cola',
                                'assets/img/brands/toyota.svg' => 'Toyota',
                                'assets/img/brands/nike.svg' => 'Nike',
                                'assets/img/brands/intel.svg' => 'Intel',
                                'assets/img/brands/samsung.svg' => 'Samsung',
                                'assets/img/brands/bmw.svg' => 'BMW',
                                'assets/img/brands/accenture.svg' => 'Accenture',
                                'assets/img/brands/walmart.svg' => 'Walmart',
                                'assets/img/brands/unilever.svg' => 'Unilever',
                            ];
                        @endphp
                        @foreach($presetBrands as $path => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="preset_logo" value="{{ $path }}" class="peer sr-only" {{ old('preset_logo') === $path ? 'checked' : '' }}>
                                <div class="p-3 rounded-xl border border-transparent peer-checked:border-[#0067b8] peer-checked:bg-white dark:peer-checked:bg-slate-800 peer-checked:shadow-sm hover:bg-white/60 dark:hover:bg-slate-800/60 transition-all flex flex-col items-center justify-center text-center h-20">
                                    <img src="{{ asset($path) }}" alt="{{ $label }}" class="max-h-10 max-w-full object-contain mb-1">
                                    <span class="text-[10px] font-semibold text-slate-600 dark:text-slate-400 truncate w-full">{{ $label }}</span>
                                </div>
                            </label>
                        @endforeach
                    </div>
                </div>

                <!-- Custom Logo Upload -->
                <div>
                    <label for="logo_image" class="block text-xs font-bold uppercase tracking-wider text-slate-700 dark:text-slate-300 mb-2">
                        Or Upload Custom Logo Image
                    </label>
                    <input type="file" id="logo_image" name="logo_image" accept="image/*" class="w-full px-3 py-2 text-xs rounded-xl border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 text-slate-700 dark:text-slate-300 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-xs file:font-bold file:bg-[#0067b8] file:text-white hover:file:bg-[#005a9e] cursor-pointer">
                    <p class="text-[11px] text-slate-400 mt-1">SVG, PNG or WebP with transparent background is recommended.</p>
                    @error('logo_image')
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
                        <span class="text-xs sm:text-sm font-bold text-slate-800 dark:text-slate-200">Active (Visible on website)</span>
                    </label>
                </div>

            </div>

            <!-- Form Actions -->
            <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-3">
                <a href="{{ route('admin.trusted-brands.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Cancel
                </a>
                <button type="submit" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-6 py-2.5 rounded-xl text-xs sm:text-sm shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all active:scale-95 cursor-pointer">
                    Save Brand Logo
                </button>
            </div>
        </form>
    </div>

@endsection
