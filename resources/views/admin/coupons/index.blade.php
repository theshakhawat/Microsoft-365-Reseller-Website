@extends('layouts.admin.admin')

@section('title', 'Coupon Codes & Discounts | Admin Control Center')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0067b8] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 dark:text-slate-200">Coupons & Discounts</span>
    </div>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Flash Notifications -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/80 text-emerald-800 dark:text-emerald-300 flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-500 text-lg"></i>
                <p class="text-xs sm:text-sm font-semibold">{{ session('success') }}</p>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="text-emerald-500 hover:text-emerald-700 cursor-pointer">
                <i class="fa-solid fa-xmark text-sm"></i>
            </button>
        </div>
    @endif

    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <span class="w-10 h-10 rounded-2xl bg-amber-100 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-lg shadow-xs">
                    <i class="fa-solid fa-ticket"></i>
                </span>
                <span>Coupon Codes & Discounts</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Manage promotional discount codes, validity periods, maximum usage limits, and flat/percentage rates.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.coupons.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white text-xs sm:text-sm font-bold shadow-md shadow-[#0067b8]/20 active:scale-95 transition-all">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add New Coupon</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-[#0067b8] dark:text-blue-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-ticket"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Coupons</p>
                <p class="text-lg sm:text-xl font-black text-slate-900 dark:text-white">{{ $stats['total'] }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Active Coupons</p>
                <p class="text-lg sm:text-xl font-black text-emerald-600 dark:text-emerald-400">{{ $stats['active'] }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-rose-50 dark:bg-rose-950/50 text-rose-600 dark:text-rose-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-clock-rotate-left"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Expired</p>
                <p class="text-lg sm:text-xl font-black text-rose-600 dark:text-rose-400">{{ $stats['expired'] }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-chart-pie"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Redemptions</p>
                <p class="text-lg sm:text-xl font-black text-purple-600 dark:text-purple-400">{{ $stats['total_used'] }}</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        <!-- Status Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0">
            <a href="{{ route('admin.coupons.index', ['status' => 'all', 'search' => $search]) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $statusFilter === 'all' ? 'bg-[#0067b8] text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                All ({{ $stats['total'] }})
            </a>
            <a href="{{ route('admin.coupons.index', ['status' => 'active', 'search' => $search]) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $statusFilter === 'active' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Active ({{ $stats['active'] }})
            </a>
            <a href="{{ route('admin.coupons.index', ['status' => 'expired', 'search' => $search]) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $statusFilter === 'expired' ? 'bg-rose-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Expired ({{ $stats['expired'] }})
            </a>
            <a href="{{ route('admin.coupons.index', ['status' => 'inactive', 'search' => $search]) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $statusFilter === 'inactive' ? 'bg-slate-700 text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Inactive
            </a>
        </div>

        <!-- Search Box -->
        <form method="GET" action="{{ route('admin.coupons.index') }}" class="relative w-full md:w-72">
            <input type="hidden" name="status" value="{{ $statusFilter }}">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" name="search" value="{{ $search }}" placeholder="Search coupon code or name..." 
                   class="w-full pl-9 pr-8 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] focus:border-transparent transition-all">
            @if($search)
                <a href="{{ route('admin.coupons.index', ['status' => $statusFilter]) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Coupons Table -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/75 dark:bg-slate-800/50 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        <th class="py-3.5 px-5">Coupon Code & Details</th>
                        <th class="py-3.5 px-4">Discount</th>
                        <th class="py-3.5 px-4">Validity Period</th>
                        <th class="py-3.5 px-4">Usage & Limits</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-xs">
                    @forelse($coupons as $coupon)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                            
                            <!-- Coupon Code & Details -->
                            <td class="py-4 px-5">
                                <div class="flex items-start gap-3">
                                    <div class="w-9 h-9 rounded-xl bg-amber-50 dark:bg-amber-950/50 text-amber-600 dark:text-amber-400 flex items-center justify-center text-sm font-black shrink-0 mt-0.5 border border-amber-200 dark:border-amber-800/80">
                                        <i class="fa-solid fa-tag"></i>
                                    </div>
                                    <div>
                                        <div class="flex items-center gap-2">
                                            <span class="font-black text-sm tracking-wider text-slate-900 dark:text-white font-mono bg-slate-100 dark:bg-slate-800 px-2.5 py-0.5 rounded-lg border border-slate-200 dark:border-slate-700">
                                                {{ $coupon->code }}
                                            </span>
                                            <button type="button" onclick="copyCoupon('{{ $coupon->code }}')" title="Copy coupon code" class="text-slate-400 hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors cursor-pointer">
                                                <i class="fa-regular fa-copy text-xs"></i>
                                            </button>
                                        </div>
                                        @if($coupon->name)
                                            <p class="font-bold text-slate-800 dark:text-slate-200 mt-1">{{ $coupon->name }}</p>
                                        @endif
                                        @if($coupon->description)
                                            <p class="text-[11px] text-slate-400 dark:text-slate-500 mt-0.5 max-w-xs truncate">{{ $coupon->description }}</p>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Discount Rate -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                @if($coupon->discount_type === 'percentage')
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-blue-50 dark:bg-blue-950/60 text-[#0067b8] dark:text-sky-400 font-black text-xs border border-blue-100 dark:border-blue-900">
                                        <i class="fa-solid fa-percent text-[10px]"></i>
                                        <span>{{ rtrim(rtrim(number_format($coupon->discount_value, 2), '0'), '.') }}% OFF</span>
                                    </div>
                                @else
                                    <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-full bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-400 font-black text-xs border border-emerald-100 dark:border-emerald-900">
                                        <i class="fa-solid fa-bangladeshi-taka-sign text-[10px]"></i>
                                        <span>৳{{ number_format($coupon->discount_value, 0) }} FLAT</span>
                                    </div>
                                @endif

                                <div class="mt-1 text-[11px] text-slate-500 dark:text-slate-400 space-y-0.5">
                                    @if($coupon->min_order_amount)
                                        <div>Min Order: <span class="font-bold text-slate-700 dark:text-slate-300">৳{{ number_format($coupon->min_order_amount, 0) }}</span></div>
                                    @endif
                                    @if($coupon->max_discount_amount && $coupon->discount_type === 'percentage')
                                        <div>Max Cap: <span class="font-bold text-slate-700 dark:text-slate-300">৳{{ number_format($coupon->max_discount_amount, 0) }}</span></div>
                                    @endif
                                </div>
                            </td>

                            <!-- Validity Period -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-1.5 text-slate-600 dark:text-slate-300 font-semibold">
                                        <i class="fa-regular fa-calendar text-[11px] text-slate-400"></i>
                                        <span>
                                            {{ $coupon->start_date ? $coupon->start_date->format('M d, Y') : 'Immediate' }} 
                                            → 
                                            {{ $coupon->expire_date ? $coupon->expire_date->format('M d, Y') : 'No Expiry' }}
                                        </span>
                                    </div>
                                    
                                    @if($coupon->expire_date)
                                        @if($coupon->expire_date->isPast())
                                            <span class="inline-block text-[10px] font-bold text-rose-600 dark:text-rose-400">
                                                <i class="fa-solid fa-triangle-exclamation mr-1"></i>Expired {{ $coupon->expire_date->diffForHumans() }}
                                            </span>
                                        @else
                                            <span class="inline-block text-[10px] font-bold text-slate-400 dark:text-slate-500">
                                                Expires {{ $coupon->expire_date->diffForHumans() }}
                                            </span>
                                        @endif
                                    @else
                                        <span class="inline-block text-[10px] font-bold text-emerald-600 dark:text-emerald-400">
                                            Lifetime validity
                                        </span>
                                    @endif
                                </div>
                            </td>

                            <!-- Usage & Limits -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="space-y-1">
                                    <div class="flex items-center gap-2">
                                        <span class="font-black text-slate-800 dark:text-slate-200">{{ $coupon->used_count }}</span>
                                        <span class="text-slate-400">/</span>
                                        <span class="text-slate-500 dark:text-slate-400">{{ $coupon->max_uses ? $coupon->max_uses . ' max' : 'Unlimited' }}</span>
                                    </div>

                                    @if($coupon->max_uses)
                                        @php
                                            $percentUsed = min(100, round(($coupon->used_count / $coupon->max_uses) * 100));
                                        @endphp
                                        <div class="w-24 h-1.5 rounded-full bg-slate-100 dark:bg-slate-800 overflow-hidden">
                                            <div class="h-full rounded-full {{ $percentUsed >= 100 ? 'bg-rose-500' : ($percentUsed > 75 ? 'bg-amber-500' : 'bg-blue-500') }}" style="width: {{ $percentUsed }}%"></div>
                                        </div>
                                    @endif

                                    <div class="text-[10px] text-slate-400 font-semibold">
                                        Per person: <span class="text-slate-600 dark:text-slate-300 font-bold">{{ $coupon->max_uses_per_user ?? 1 }}</span>
                                    </div>
                                </div>
                            </td>

                            <!-- Status & Quick Toggle -->
                            <td class="py-4 px-4 whitespace-nowrap">
                                <div class="flex items-center gap-2">
                                    @if(!$coupon->is_active)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span>
                                            Inactive
                                        </span>
                                    @elseif($coupon->is_expired)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-rose-100 text-rose-700 dark:bg-rose-950/80 dark:text-rose-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-rose-500"></span>
                                            Expired
                                        </span>
                                    @elseif($coupon->is_upcoming)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-amber-100 text-amber-700 dark:bg-amber-950/80 dark:text-amber-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-amber-500"></span>
                                            Upcoming
                                        </span>
                                    @elseif($coupon->is_exhausted)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-orange-100 text-orange-700 dark:bg-orange-950/80 dark:text-orange-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-orange-500"></span>
                                            Limit Reached
                                        </span>
                                    @else
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold bg-emerald-100 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-400">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            Active
                                        </span>
                                    @endif

                                    <!-- Quick Toggle Form -->
                                    <form action="{{ route('admin.coupons.toggle', $coupon) }}" method="POST">
                                        @csrf
                                        <button type="submit" class="p-1.5 rounded-lg text-xs font-bold transition-all {{ $coupon->is_active ? 'text-emerald-600 hover:bg-emerald-50 dark:hover:bg-emerald-950/40' : 'text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}" title="{{ $coupon->is_active ? 'Click to Deactivate' : 'Click to Activate' }}">
                                            <i class="fa-solid {{ $coupon->is_active ? 'fa-toggle-on text-lg text-emerald-600 dark:text-emerald-400' : 'fa-toggle-off text-lg text-slate-400' }}"></i>
                                        </button>
                                    </form>
                                </div>
                            </td>

                            <!-- Action Buttons -->
                            <td class="py-4 px-5 whitespace-nowrap text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.coupons.edit', $coupon) }}" 
                                       class="p-2 text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl text-xs font-bold transition-colors" 
                                       title="Edit Coupon">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>

                                    <button type="button" 
                                            onclick="openDeleteModal('{{ route('admin.coupons.destroy', $coupon) }}', '{{ addslashes($coupon->code) }}')" 
                                            class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/50 rounded-xl text-xs transition-colors cursor-pointer" 
                                            title="Delete Coupon">
                                        <i class="fa-solid fa-trash"></i>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-16 text-center text-slate-400 dark:text-slate-500">
                                <div class="max-w-sm mx-auto flex flex-col items-center">
                                    <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-2xl text-slate-400 mb-3">
                                        <i class="fa-solid fa-ticket"></i>
                                    </div>
                                    <h3 class="text-base font-bold text-slate-800 dark:text-slate-200">No Coupon Codes Found</h3>
                                    <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-4">
                                        {{ $search || $statusFilter !== 'all' ? 'No coupons matched your filter criteria.' : 'Create your first promotional coupon to offer discounts to customers.' }}
                                    </p>
                                    @if($search || $statusFilter !== 'all')
                                        <a href="{{ route('admin.coupons.index') }}" class="px-4 py-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-200">
                                            Clear Filters
                                        </a>
                                    @else
                                        <a href="{{ route('admin.coupons.create') }}" class="px-5 py-2.5 rounded-xl bg-[#0067b8] text-white text-xs font-bold hover:bg-[#005a9e] shadow-md shadow-[#0067b8]/20">
                                            <i class="fa-solid fa-plus mr-1"></i> Add New Coupon
                                        </a>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full p-6 border border-slate-200 dark:border-slate-800 shadow-2xl space-y-4">
        <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center text-xl">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div>
            <h3 class="text-lg font-black text-slate-900 dark:text-white">Delete Coupon Code</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Are you sure you want to permanently delete coupon code <span id="deleteCouponCode" class="font-bold text-slate-900 dark:text-white font-mono"></span>? This action cannot be undone.
            </p>
        </div>
        <form id="deleteForm" method="POST" class="flex items-center justify-end gap-3 pt-2">
            @csrf
            @method('DELETE')
            <button type="button" onclick="closeDeleteModal()" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer">
                Cancel
            </button>
            <button type="submit" class="px-5 py-2 rounded-xl text-xs font-bold bg-rose-600 hover:bg-rose-700 text-white shadow-md shadow-rose-600/25 transition-all cursor-pointer">
                Yes, Delete
            </button>
        </form>
    </div>
</div>

<!-- Copy Toast Notification -->
<div id="copyToast" class="fixed bottom-6 right-6 z-50 bg-slate-900 text-white px-4 py-2.5 rounded-xl shadow-xl text-xs font-bold flex items-center gap-2 transform translate-y-20 opacity-0 transition-all duration-300">
    <i class="fa-solid fa-check text-emerald-400"></i>
    <span>Coupon code copied to clipboard!</span>
</div>

<script>
    function openDeleteModal(url, code) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteCouponCode').textContent = code;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }

    function copyCoupon(code) {
        navigator.clipboard.writeText(code).then(() => {
            const toast = document.getElementById('copyToast');
            toast.classList.remove('translate-y-20', 'opacity-0');
            setTimeout(() => {
                toast.classList.add('translate-y-20', 'opacity-0');
            }, 2500);
        });
    }
</script>
@endsection
