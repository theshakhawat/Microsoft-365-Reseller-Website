@extends('layouts.admin.admin')

@section('title', 'Pricing Plans Management | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        Pricing Plans
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
                Microsoft 365 Pricing Plans
            </h2>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Create, edit, toggle visibility, adjust pricing & features for website cards.
            </p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('home') }}#plans" target="_blank" class="hidden sm:flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#0067b8] dark:text-sky-400"></i>
                <span>Preview on Site</span>
            </a>
            <a href="{{ route('admin.plans.create') }}" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-5 py-2.5 rounded-xl text-xs sm:text-sm flex items-center gap-2 shadow-md shadow-[#0067b8]/25 hover:shadow-lg transition-all self-start sm:self-auto active:scale-95 cursor-pointer">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add New Plan</span>
            </a>
        </div>
    </div>

    <!-- Plans Cards Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($plans as $plan)
            <div class="bg-white dark:bg-slate-900 rounded-3xl border {{ $plan->is_featured ? 'border-2 border-[#0067b8] dark:border-sky-500 shadow-lg' : 'border-slate-200/90 dark:border-slate-800 shadow-sm' }} p-6 flex flex-col justify-between relative transition-all">
                
                <!-- Top status & badge -->
                <div>
                    <div class="flex items-center justify-between gap-2 mb-3">
                        @if($plan->badge)
                            <span class="text-[10px] font-bold uppercase bg-sky-100 dark:bg-sky-950 text-[#0067b8] dark:text-sky-400 px-2.5 py-1 rounded-full border border-sky-200 dark:border-sky-800 flex items-center gap-1">
                                <i class="fa-solid fa-fire text-amber-500 text-[10px]"></i>
                                {{ $plan->badge }}
                            </span>
                        @else
                            <span class="text-[10px] font-bold uppercase bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 px-2 py-0.5 rounded-md">
                                Standard Plan
                            </span>
                        @endif

                        <div class="flex items-center gap-2">
                            <form action="{{ route('admin.plans.toggle', $plan) }}" method="POST">
                                @csrf
                                <button type="submit" class="text-[11px] font-bold px-2.5 py-1 rounded-full cursor-pointer transition-all {{ $plan->is_active ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-400 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 hover:bg-slate-200' }}" title="Click to Toggle Active/Inactive">
                                    <span class="w-1.5 h-1.5 rounded-full inline-block mr-1 {{ $plan->is_active ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                    {{ $plan->is_active ? 'Active' : 'Hidden' }}
                                </button>
                            </form>
                        </div>
                    </div>

                    <h3 class="text-lg font-black text-slate-900 dark:text-white">{{ $plan->name }}</h3>
                    
                    <!-- Price Display -->
                    <div class="mt-2 mb-4">
                        <span class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white">{{ $plan->price_bdt }}</span>
                        <span class="text-xs font-semibold text-slate-500 dark:text-slate-400">/{{ $plan->billing_period }}</span>
                        @if($plan->price_usd)
                            <span class="text-[11px] text-slate-400 ml-1">({{ $plan->price_usd }})</span>
                        @endif
                    </div>

                    <!-- Features bullet count -->
                    <div class="bg-slate-50 dark:bg-slate-800/60 rounded-2xl p-3 mb-4 text-xs text-slate-600 dark:text-slate-300">
                        <p class="font-bold text-slate-900 dark:text-white mb-1.5">{{ count($plan->features ?? []) }} Features Included:</p>
                        <ul class="space-y-1">
                            @foreach(array_slice($plan->features ?? [], 0, 3) as $f)
                                <li class="flex items-center gap-1.5 truncate">
                                    <i class="fa-solid fa-check text-emerald-500 text-[10px]"></i>
                                    <span class="truncate">{{ strip_tags($f) }}</span>
                                </li>
                            @endforeach
                            @if(count($plan->features ?? []) > 3)
                                <li class="text-[10px] text-slate-400 font-semibold pt-0.5">+ {{ count($plan->features) - 3 }} more features...</li>
                            @endif
                        </ul>
                    </div>

                    <!-- Apps included count -->
                    @if(!empty($plan->included_apps) && is_array($plan->included_apps))
                        <div class="flex items-center gap-1.5 mb-4">
                            @foreach($plan->included_apps as $appKey)
                                <img src="{{ asset('assets/img/products/' . strtolower($appKey) . '.png') }}" class="w-5 h-5 object-contain" alt="{{ $appKey }}" title="{{ $appKey }}">
                            @endforeach
                        </div>
                    @endif
                </div>

                <!-- Card Action Buttons -->
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between gap-2">
                    <a href="{{ route('admin.plans.edit', $plan) }}" class="flex-1 text-center py-2 px-3 rounded-xl text-xs font-bold bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-300 transition-colors">
                        <i class="fa-regular fa-pen-to-square mr-1"></i> Edit Plan
                    </a>

                    <button type="button" onclick="openDeleteModal('{{ route('admin.plans.destroy', $plan) }}', '{{ addslashes($plan->name) }}')" class="p-2 rounded-xl text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/50 transition-colors cursor-pointer" title="Delete Plan">
                        <i class="fa-regular fa-trash-can text-sm"></i>
                    </button>
                </div>

            </div>
        @empty
            <div class="col-span-3 py-12 text-center text-slate-400 bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8">
                <i class="fa-solid fa-box-open text-4xl mb-3 text-slate-300 dark:text-slate-600"></i>
                <p class="font-bold text-slate-600 dark:text-slate-300">No Pricing Plans configured yet</p>
                <p class="text-xs text-slate-400 mt-1">Click "Add New Plan" to create your first pricing card.</p>
            </div>
        @endforelse
    </div>

@endsection
