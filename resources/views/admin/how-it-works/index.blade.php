@extends('layouts.admin.admin')

@section('title', 'How It Works Steps Management | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        How It Works Steps
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

    <!-- Page Title & Create Button -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                How It Works Activation Steps
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Manage the step-by-step activation guide cards displayed on the homepage.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}#how-it-works" target="_blank" class="hidden sm:flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#0067b8] dark:text-sky-400"></i>
                <span>Preview on Site</span>
            </a>
            <a href="{{ route('admin.how-it-works.create') }}" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-5 py-2.5 rounded-xl text-xs sm:text-sm flex items-center gap-2 shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all self-start sm:self-auto active:scale-95 cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add New Step</span>
            </a>
        </div>
    </div>

    <!-- Step Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
        @forelse($steps as $step)
            @php
                $bgClass = match($step->icon_bg_color) {
                    'purple' => 'bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 border-purple-100 dark:border-purple-900/50',
                    'amber' => 'bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 border-amber-100 dark:border-amber-900/50',
                    'emerald' => 'bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 border-emerald-100 dark:border-emerald-900/50',
                    default => 'bg-sky-50 dark:bg-sky-950/50 text-[#0067b8] dark:text-sky-400 border-sky-100 dark:border-sky-900/50',
                };
                $badgeTextClass = match($step->badge_color) {
                    'amber' => 'text-amber-600 dark:text-amber-400',
                    'sky' => 'text-sky-600 dark:text-sky-400',
                    'purple' => 'text-purple-600 dark:text-purple-400',
                    default => 'text-emerald-600 dark:text-emerald-400',
                };
            @endphp
            <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 p-6 flex flex-col justify-between shadow-sm hover:shadow-md transition-all relative">
                
                <div>
                    <!-- Header with Step Number & Status Toggle -->
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <span class="text-xs font-black uppercase tracking-wider bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 px-2.5 py-1 rounded-md">
                            Step {{ $step->step_number ?? ($loop->iteration < 10 ? '0'.$loop->iteration : $loop->iteration) }}
                        </span>

                        <form action="{{ route('admin.how-it-works.toggle', $step) }}" method="POST">
                            @csrf
                            <button type="submit" class="text-[11px] font-bold px-2.5 py-1 rounded-full cursor-pointer transition-all {{ $step->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-400 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 hover:bg-slate-200' }}" title="Click to Toggle Active/Hidden">
                                <span class="w-1.5 h-1.5 rounded-full inline-block mr-1 {{ $step->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                {{ $step->is_active ? 'Active' : 'Hidden' }}
                            </button>
                        </form>
                    </div>

                    <!-- Step Icon -->
                    <div class="w-12 h-12 rounded-xl {{ $bgClass }} border flex items-center justify-center text-xl mb-4 shadow-xs">
                        <i class="{{ $step->icon }}"></i>
                    </div>

                    <!-- Title & Description -->
                    <h3 class="text-base font-bold text-slate-900 dark:text-white mb-2">{{ $step->title }}</h3>
                    <p class="text-xs text-slate-600 dark:text-slate-400 leading-relaxed mb-4">
                        {{ $step->description }}
                    </p>
                </div>

                <div>
                    <!-- Bottom Badge -->
                    @if($step->badge_text)
                        <div class="pt-3 border-t border-slate-100 dark:border-slate-800 text-[11px] font-semibold flex items-center gap-1.5 {{ $badgeTextClass }} mb-4">
                            <i class="{{ $step->badge_icon ?? 'fa-solid fa-circle-check' }}"></i>
                            <span>{{ $step->badge_text }}</span>
                        </div>
                    @endif

                    <!-- Action Buttons -->
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2">
                        <span class="text-[10px] text-slate-400 font-bold">Order: {{ $step->sort_order }}</span>
                        <div class="flex items-center gap-1.5">
                            <a href="{{ route('admin.how-it-works.edit', $step) }}" class="p-2 text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-lg text-xs font-bold transition-colors" title="Edit Step">
                                <i class="fa-solid fa-pen-to-square"></i>
                            </a>

                            <button type="button" onclick="openDeleteModal('{{ route('admin.how-it-works.destroy', $step) }}', '{{ addslashes($step->title) }}')" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/50 rounded-lg text-xs transition-colors cursor-pointer" title="Delete Step">
                                <i class="fa-solid fa-trash"></i>
                            </button>
                        </div>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8">
                <i class="fa-solid fa-list-check text-4xl text-slate-300 dark:text-slate-600 mb-3"></i>
                <h4 class="text-base font-bold text-slate-800 dark:text-slate-200">No Steps Found</h4>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-4">Click below to create your first How It Works step.</p>
                <a href="{{ route('admin.how-it-works.create') }}" class="bg-[#0067b8] text-white font-bold px-5 py-2.5 rounded-xl text-xs inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Add Step
                </a>
            </div>
        @endforelse
    </div>

@endsection
