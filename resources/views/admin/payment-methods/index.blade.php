@extends('layouts.admin.admin')

@section('title', 'Payment Methods Management | Admin Control Center')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0067b8] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 dark:text-slate-200">Payment Methods</span>
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
                <span class="w-10 h-10 rounded-2xl bg-emerald-100 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg shadow-xs">
                    <i class="fa-solid fa-credit-card"></i>
                </span>
                <span>Payment Methods</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Configure payment gateways (bKash, Nagad, MoneyBag, PayPal) available for checkout.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.payment-methods.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white text-xs sm:text-sm font-bold shadow-md shadow-[#0067b8]/20 active:scale-95 transition-all">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>Add Payment Method</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-[#0067b8] dark:text-blue-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-wallet"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Gateways</p>
                <p class="text-lg sm:text-xl font-black text-slate-900 dark:text-white">{{ $stats['total'] }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-circle-check"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Active on Checkout</p>
                <p class="text-lg sm:text-xl font-black text-emerald-600 dark:text-emerald-400">{{ $stats['active'] }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 dark:text-slate-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-toggle-off"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Disabled Gateways</p>
                <p class="text-lg sm:text-xl font-black text-slate-700 dark:text-slate-300">{{ $stats['inactive'] }}</p>
            </div>
        </div>
    </div>

    <!-- Search & Filter Controls -->
    <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        <!-- Status Tabs -->
        <div class="flex items-center gap-1.5 overflow-x-auto pb-1 md:pb-0">
            <a href="{{ route('admin.payment-methods.index', ['status' => 'all', 'search' => $search]) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $statusFilter === 'all' ? 'bg-[#0067b8] text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                All ({{ $stats['total'] }})
            </a>
            <a href="{{ route('admin.payment-methods.index', ['status' => 'active', 'search' => $search]) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $statusFilter === 'active' ? 'bg-emerald-600 text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Active ({{ $stats['active'] }})
            </a>
            <a href="{{ route('admin.payment-methods.index', ['status' => 'inactive', 'search' => $search]) }}" 
               class="px-3.5 py-1.5 rounded-xl text-xs font-bold transition-all {{ $statusFilter === 'inactive' ? 'bg-slate-700 text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800' }}">
                Inactive ({{ $stats['inactive'] }})
            </a>
        </div>

        <!-- Search Box -->
        <form method="GET" action="{{ route('admin.payment-methods.index') }}" class="relative w-full md:w-72">
            <input type="hidden" name="status" value="{{ $statusFilter }}">
            <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
            <input type="text" name="search" value="{{ $search }}" placeholder="Search by name, slug or notes..." 
                   class="w-full pl-9 pr-8 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] focus:border-transparent transition-all">
            @if($search)
                <a href="{{ route('admin.payment-methods.index', ['status' => $statusFilter]) }}" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-400 hover:text-slate-600 dark:hover:text-white">
                    <i class="fa-solid fa-xmark text-xs"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Payment Methods Grid / Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
        @forelse($paymentMethods as $method)
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-5 flex flex-col justify-between shadow-xs hover:shadow-md transition-all relative group">
                
                <div>
                    <!-- Top Status & Slug Badge -->
                    <div class="flex items-center justify-between gap-2 mb-4">
                        <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg text-xs font-mono font-bold uppercase tracking-wider bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 border border-slate-200 dark:border-slate-700">
                            <i class="fa-solid fa-code text-[10px] text-slate-400"></i>
                            slug: {{ $method->slug }}
                        </span>

                        <!-- Quick Status Toggle -->
                        <form action="{{ route('admin.payment-methods.toggle', $method) }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[11px] font-bold transition-all cursor-pointer {{ $method->status ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-400 hover:bg-emerald-200' : 'bg-slate-100 text-slate-500 dark:bg-slate-800 dark:text-slate-400 hover:bg-slate-200' }}" title="Click to toggle status">
                                <span class="w-1.5 h-1.5 rounded-full inline-block {{ $method->status ? 'bg-emerald-500' : 'bg-slate-400' }}"></span>
                                {{ $method->status ? 'Active' : 'Disabled' }}
                            </button>
                        </form>
                    </div>

                    <!-- Logo and Method Name -->
                    <div class="flex items-center gap-3.5 mb-3">
                        <div class="w-14 h-14 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-100 dark:border-slate-700/80 p-2 flex items-center justify-center shrink-0 overflow-hidden shadow-xs">
                            @if($method->logo)
                                <img src="{{ $method->logo_url }}" alt="{{ $method->name }}" class="max-w-full max-h-full object-contain" onerror="this.onerror=null; this.src=''; this.parentElement.innerHTML='<i class=\'fa-solid fa-credit-card text-slate-400 text-xl\'></i>';">
                            @else
                                <i class="fa-solid fa-credit-card text-slate-400 text-xl"></i>
                            @endif
                        </div>
                        <div class="min-w-0 flex-1">
                            <h3 class="text-base font-black text-slate-900 dark:text-white truncate">{{ $method->name }}</h3>
                            <p class="text-[11px] text-slate-400 font-semibold">Order Priority: {{ $method->sort_order }}</p>
                        </div>
                    </div>

                    <!-- Instructions -->
                    @if($method->instruction)
                        <div class="p-3 rounded-2xl bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-800/60 text-xs text-slate-600 dark:text-slate-400 line-clamp-2">
                            {{ $method->instruction }}
                        </div>
                    @else
                        <div class="p-3 rounded-2xl bg-slate-50/50 dark:bg-slate-800/30 border border-dashed border-slate-200 dark:border-slate-800 text-[11px] text-slate-400 italic">
                            No checkout instructions provided.
                        </div>
                    @endif
                </div>

                <!-- Footer: Actions -->
                <div class="pt-4 mt-4 border-t border-slate-100 dark:border-slate-800 flex items-center justify-between">
                    <span class="text-[10px] font-bold text-slate-400 uppercase">
                        Driver: <span class="font-mono text-slate-600 dark:text-slate-300 font-black">{{ $method->slug }}</span>
                    </span>

                    <div class="flex items-center gap-1.5">
                        <a href="{{ route('admin.payment-methods.edit', $method) }}" 
                           class="p-2 text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl text-xs font-bold transition-colors" 
                           title="Edit Payment Method">
                            <i class="fa-solid fa-pen-to-square"></i>
                        </a>

                        <button type="button" 
                                onclick="openDeleteModal('{{ route('admin.payment-methods.destroy', $method) }}', '{{ addslashes($method->name) }}')" 
                                class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/50 rounded-xl text-xs transition-colors cursor-pointer" 
                                title="Delete Payment Method">
                            <i class="fa-solid fa-trash"></i>
                        </button>
                    </div>
                </div>

            </div>
        @empty
            <div class="col-span-full py-16 text-center bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-8">
                <div class="w-16 h-16 rounded-full bg-slate-100 dark:bg-slate-800 flex items-center justify-center text-2xl text-slate-400 mx-auto mb-3">
                    <i class="fa-solid fa-credit-card"></i>
                </div>
                <h3 class="text-base font-bold text-slate-800 dark:text-slate-200">No Payment Methods Found</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 mb-4">
                    {{ $search || $statusFilter !== 'all' ? 'No payment methods matched your filters.' : 'Add your first payment method (e.g. bKash, Nagad, MoneyBag) to accept payments.' }}
                </p>
                <a href="{{ route('admin.payment-methods.create') }}" class="px-5 py-2.5 rounded-xl bg-[#0067b8] text-white text-xs font-bold hover:bg-[#005a9e] shadow-md shadow-[#0067b8]/20 inline-flex items-center gap-2">
                    <i class="fa-solid fa-plus text-xs"></i> Add Payment Method
                </a>
            </div>
        @endforelse
    </div>

</div>

<!-- Delete Confirmation Modal -->
<div id="deleteModal" class="fixed inset-0 z-50 bg-black/50 backdrop-blur-xs hidden flex items-center justify-center p-4">
    <div class="bg-white dark:bg-slate-900 rounded-3xl max-w-md w-full p-6 border border-slate-200 dark:border-slate-800 shadow-2xl space-y-4">
        <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center text-xl">
            <i class="fa-solid fa-triangle-exclamation"></i>
        </div>
        <div>
            <h3 class="text-lg font-black text-slate-900 dark:text-white">Delete Payment Method</h3>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1">
                Are you sure you want to permanently delete payment gateway <span id="deleteMethodName" class="font-bold text-slate-900 dark:text-white"></span>? This method will no longer be available on checkout.
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

<script>
    function openDeleteModal(url, name) {
        document.getElementById('deleteForm').action = url;
        document.getElementById('deleteMethodName').textContent = name;
        document.getElementById('deleteModal').classList.remove('hidden');
    }

    function closeDeleteModal() {
        document.getElementById('deleteModal').classList.add('hidden');
    }
</script>
@endsection

