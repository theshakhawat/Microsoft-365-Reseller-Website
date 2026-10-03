@extends('layouts.admin.admin')

@section('title', 'Trusted Brands Management | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        Trusted Brands
    </span>
@endsection

@section('content')

    <!-- Success Alert -->
    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-xs">
            <i class="fa-solid fa-circle-check text-lg text-emerald-600 dark:text-emerald-400 shrink-0"></i>
            <p class="text-xs sm:text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Page Title & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                Trusted Brands Management
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Manage the dynamic brand logos displayed in the "Trusted by millions around the world" section.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}#trusted-by" target="_blank" class="hidden sm:flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#0067b8] dark:text-sky-400"></i>
                <span>Preview on Site</span>
            </a>
            <a href="{{ route('admin.trusted-brands.create') }}" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-5 py-2.5 rounded-xl text-xs sm:text-sm flex items-center gap-2 shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all self-start sm:self-auto active:scale-95 cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add New Brand</span>
            </a>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Brands</p>
                <p class="text-xl font-black text-slate-900 dark:text-white mt-0.5">{{ $stats['total'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-base">
                <i class="fa-solid fa-award"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Active Visible</p>
                <p class="text-xl font-black text-emerald-600 dark:text-emerald-400 mt-0.5">{{ $stats['active'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base">
                <i class="fa-solid fa-circle-check"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Hidden Brands</p>
                <p class="text-xl font-black text-slate-500 dark:text-slate-400 mt-0.5">{{ $stats['hidden'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 flex items-center justify-center text-base">
                <i class="fa-solid fa-eye-slash"></i>
            </div>
        </div>
    </div>

    <!-- Brand Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5 gap-5">
        @forelse($brands as $brand)
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 p-5 flex flex-col justify-between shadow-xs hover:shadow-md transition-all duration-200">
                
                <div>
                    <!-- Top Status Switcher & Sort -->
                    <div class="flex items-center justify-between gap-2 mb-3">
                        <span class="text-[10px] text-slate-400 font-bold bg-slate-100 dark:bg-slate-800 px-2 py-0.5 rounded">
                            Order: {{ $brand->sort_order }}
                        </span>

                        <form action="{{ route('admin.trusted-brands.toggle', $brand) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-[10px] font-bold px-2 py-0.5 rounded-full cursor-pointer transition-all {{ $brand->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-400 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 hover:bg-slate-200' }}" title="Click to Toggle Active Status">
                                <span class="w-1.5 h-1.5 rounded-full inline-block mr-0.5 {{ $brand->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                {{ $brand->is_active ? 'Active' : 'Hidden' }}
                            </button>
                        </form>
                    </div>

                    <!-- Logo Display Box -->
                    <div class="rounded-xl overflow-hidden bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-800 h-24 flex items-center justify-center p-3 mb-3">
                        @if($brand->logo_image)
                            <img src="{{ asset($brand->logo_image) }}" alt="{{ $brand->name }}" class="max-h-full max-w-full object-contain transition-transform duration-300 hover:scale-105">
                        @else
                            <span class="text-xs text-slate-400 font-bold">{{ $brand->name }}</span>
                        @endif
                    </div>

                    <!-- Brand Name & Website -->
                    <h3 class="text-sm font-bold text-slate-900 dark:text-white truncate">
                        {{ $brand->name }}
                    </h3>
                    @if($brand->website_url)
                        <a href="{{ $brand->website_url }}" target="_blank" class="text-[11px] text-[#0067b8] dark:text-sky-400 hover:underline truncate block mt-0.5">
                            {{ $brand->website_url }}
                        </a>
                    @else
                        <span class="text-[11px] text-slate-400 italic block mt-0.5">No URL attached</span>
                    @endif
                </div>

                <!-- Action Buttons -->
                <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-end gap-1.5 mt-3">
                    <a href="{{ route('admin.trusted-brands.edit', $brand) }}" class="p-2 text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-xs font-bold transition-colors" title="Edit Brand">
                        <i class="fa-solid fa-pen-to-square"></i>
                    </a>

                    <!-- Custom Delete Modal Trigger -->
                    <button type="button" onclick="openDeleteModal('{{ route('admin.trusted-brands.destroy', $brand) }}', '{{ addslashes($brand->name) }}')" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/50 rounded-lg text-xs transition-colors cursor-pointer" title="Delete Brand">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8">
                <i class="fa-solid fa-award text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
                <h4 class="text-base font-bold text-slate-800 dark:text-slate-200">No Brands Found</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-4">Click below to add your first trusted brand logo.</p>
                <a href="{{ route('admin.trusted-brands.create') }}" class="bg-[#0067b8] text-white font-bold px-5 py-2.5 rounded-xl text-xs inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Add New Brand
                </a>
            </div>
        @endforelse
    </div>

@endsection
