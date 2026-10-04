@extends('layouts.admin.admin')

@section('title', 'More Benefits Management | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        More Benefits
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
                Explore More Benefits Management
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Manage the 6 feature benefit cards shown in the "Explore even more benefits of Microsoft 365" section.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}#more-benefits" target="_blank" class="hidden sm:flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#0067b8] dark:text-sky-400"></i>
                <span>Preview on Site</span>
            </a>
            <a href="{{ route('admin.more-benefits.create') }}" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-5 py-2.5 rounded-xl text-xs sm:text-sm flex items-center gap-2 shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all self-start sm:self-auto active:scale-95 cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add New Benefit</span>
            </a>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-3 gap-4">
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Benefits</p>
                <p class="text-xl font-black text-slate-900 dark:text-white mt-0.5">{{ $stats['total'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-base">
                <i class="fa-solid fa-gift"></i>
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
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Hidden</p>
                <p class="text-xl font-black text-slate-500 dark:text-slate-400 mt-0.5">{{ $stats['hidden'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 flex items-center justify-center text-base">
                <i class="fa-solid fa-eye-slash"></i>
            </div>
        </div>
    </div>

    <!-- Benefit Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($benefits as $benefit)
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 flex flex-col justify-between shadow-xs hover:shadow-md transition-all duration-200">
                
                <div>
                    <!-- Top Icon & Status Toggle -->
                    <div class="flex items-center justify-between gap-3 mb-4">
                        <div class="w-12 h-12 rounded-2xl bg-slate-50 dark:bg-slate-800 border border-slate-100 dark:border-slate-700/80 flex items-center justify-center p-2.5 shadow-2xs">
                            @if($benefit->icon_image)
                                <img src="{{ asset($benefit->icon_image) }}" alt="{{ $benefit->title }}" class="w-full h-full object-contain">
                            @else
                                <i class="fa-solid fa-layer-group text-slate-400 text-lg"></i>
                            @endif
                        </div>

                        <form action="{{ route('admin.more-benefits.toggle', $benefit) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-[10px] font-bold px-2.5 py-1 rounded-full cursor-pointer transition-all {{ $benefit->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-400 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 hover:bg-slate-200' }}" title="Click to Toggle Active Status">
                                <span class="w-1.5 h-1.5 rounded-full inline-block mr-1 {{ $benefit->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                {{ $benefit->is_active ? 'Active' : 'Hidden' }}
                            </button>
                        </form>
                    </div>

                    <!-- Title & Description -->
                    <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2 leading-snug">
                        {{ $benefit->title }}
                    </h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed">
                        {{ $benefit->description }}
                    </p>
                </div>

                <!-- Footer: Order & Action Buttons -->
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2 mt-5">
                    <span class="text-[10px] text-slate-400 font-bold bg-slate-100 dark:bg-slate-800 px-2.5 py-0.5 rounded-md">
                        Order: {{ $benefit->sort_order }}
                    </span>

                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('admin.more-benefits.edit', $benefit) }}" class="p-2 text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-xs font-bold transition-colors" title="Edit Benefit">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <!-- Custom Delete Modal Trigger -->
                        <button type="button" onclick="openDeleteModal('{{ route('admin.more-benefits.destroy', $benefit) }}', '{{ addslashes($benefit->title) }}')" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/50 rounded-lg text-xs transition-colors cursor-pointer" title="Delete Benefit">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8">
                <i class="fa-solid fa-gift text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
                <h4 class="text-base font-bold text-slate-800 dark:text-slate-200">No Benefit Cards Found</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-4">Click below to add your first benefit card.</p>
                <a href="{{ route('admin.more-benefits.create') }}" class="bg-[#0067b8] text-white font-bold px-5 py-2.5 rounded-xl text-xs inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Add New Benefit
                </a>
            </div>
        @endforelse
    </div>

@endsection
