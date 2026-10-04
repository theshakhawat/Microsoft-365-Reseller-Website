@extends('layouts.admin.admin')

@section('title', 'Subscriptions & Licenses | Microsoft Office Club Admin')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Subscriptions</span>
@endsection

@section('content')

    <!-- Flash Success/Error Message -->
    @if(session('success'))
    <div class="mb-6 p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 text-xs sm:text-sm flex items-center justify-between shadow-xs">
        <div class="flex items-center gap-3">
            <i class="fa-solid fa-circle-check text-base text-emerald-600 dark:text-emerald-400"></i>
            <span class="font-bold">{{ session('success') }}</span>
        </div>
        <button onclick="this.parentElement.remove()" class="text-emerald-600 hover:text-emerald-800 dark:text-emerald-400">
            <i class="fa-solid fa-xmark text-sm"></i>
        </button>
    </div>
    @endif

    <div class="space-y-6">
        
        <!-- Header -->
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div>
                <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight">
                    Customer Subscriptions & Licenses
                </h1>
                <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                    Manage active Microsoft 365 licenses, extend expiration, suspend or assign manually.
                </p>
            </div>
            <div>
                <a href="{{ route('admin.subscriptions.create') }}" class="px-4 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold text-xs flex items-center gap-2 shadow-sm shadow-[#0067b8]/20 transition-all">
                    <i class="fa-solid fa-plus text-xs"></i>
                    <span>Add / Provision License</span>
                </a>
            </div>
        </div>

        <!-- Metric Badges -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <a href="{{ route('admin.subscriptions.index') }}" class="p-4 rounded-2xl border transition-all {{ !request('status') ? 'bg-[#0067b8]/10 border-[#0067b8] dark:bg-[#0067b8]/20' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800' }}">
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">All Subscriptions</p>
                <p class="text-xl font-black text-slate-900 dark:text-white mt-1">{{ $counts['all'] }}</p>
            </a>

            <a href="{{ route('admin.subscriptions.index', ['status' => 'active']) }}" class="p-4 rounded-2xl border transition-all {{ request('status') === 'active' ? 'bg-emerald-50 border-emerald-400 dark:bg-emerald-950/40' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800' }}">
                <p class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 uppercase tracking-wider">Active & Genuine</p>
                <p class="text-xl font-black text-emerald-700 dark:text-emerald-300 mt-1">{{ $counts['active'] }}</p>
            </a>

            <a href="{{ route('admin.subscriptions.index', ['status' => 'suspended']) }}" class="p-4 rounded-2xl border transition-all {{ request('status') === 'suspended' ? 'bg-amber-50 border-amber-400 dark:bg-amber-950/40' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800' }}">
                <p class="text-[11px] font-bold text-amber-600 dark:text-amber-400 uppercase tracking-wider">Suspended</p>
                <p class="text-xl font-black text-amber-700 dark:text-amber-300 mt-1">{{ $counts['suspended'] }}</p>
            </a>

            <a href="{{ route('admin.subscriptions.index', ['status' => 'expired']) }}" class="p-4 rounded-2xl border transition-all {{ request('status') === 'expired' ? 'bg-rose-50 border-rose-400 dark:bg-rose-950/40' : 'bg-white dark:bg-slate-900 border-slate-200/90 dark:border-slate-800' }}">
                <p class="text-[11px] font-bold text-rose-600 dark:text-rose-400 uppercase tracking-wider">Expired</p>
                <p class="text-xl font-black text-rose-700 dark:text-rose-300 mt-1">{{ $counts['expired'] }}</p>
            </a>
        </div>

        <!-- Search Bar -->
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 flex items-center justify-between gap-3 shadow-xs">
            <form action="{{ route('admin.subscriptions.index') }}" method="GET" class="flex-1 w-full flex items-center gap-2">
                @if(request('status'))
                    <input type="hidden" name="status" value="{{ request('status') }}">
                @endif
                <div class="relative flex-1">
                    <span class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                        <i class="fa-solid fa-magnifying-glass text-xs"></i>
                    </span>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by customer name, license email, plan, or key..." class="w-full pl-9 pr-3.5 py-2 bg-slate-50 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                </div>
                <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 dark:bg-slate-800 dark:hover:bg-slate-700 text-white font-bold text-xs rounded-xl transition-all shrink-0">
                    Search
                </button>
            </form>
        </div>

        <!-- Subscriptions Table -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left text-xs">
                    <thead>
                        <tr class="bg-slate-50/70 dark:bg-slate-800/50 border-b border-slate-200/90 dark:border-slate-800 text-slate-400 font-bold uppercase tracking-wider text-[10px]">
                            <th class="py-3.5 px-4">License / Key</th>
                            <th class="py-3.5 px-4">Customer & Account</th>
                            <th class="py-3.5 px-4">Plan & Cloud</th>
                            <th class="py-3.5 px-4">Starts - Expires</th>
                            <th class="py-3.5 px-4">Status</th>
                            <th class="py-3.5 px-4 text-right">Quick Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                        @forelse($subscriptions as $sub)
                            <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors">
                                <td class="py-3.5 px-4">
                                    <span class="font-mono font-bold text-slate-900 dark:text-white block">{{ $sub->subscription_key ?: 'M365-ACTIVE' }}</span>
                                    <span class="text-[10px] text-slate-400">Ref: {{ $sub->order ? '#' . $sub->order->order_number : 'Manual' }}</span>
                                </td>

                                <td class="py-3.5 px-4">
                                    <p class="font-bold text-slate-900 dark:text-white">{{ $sub->user->name ?? 'User' }}</p>
                                    <p class="text-[11px] text-[#0067b8] dark:text-sky-400 truncate">{{ $sub->license_email }}</p>
                                </td>

                                <td class="py-3.5 px-4">
                                    <span class="font-bold text-slate-900 dark:text-white block">{{ $sub->plan_name }}</span>
                                    <span class="text-[10px] text-purple-600 dark:text-purple-400">{{ $sub->cloud_storage }}</span>
                                </td>

                                <td class="py-3.5 px-4">
                                    <p class="font-medium">{{ $sub->starts_at?->format('M d, Y') }} &rarr; <span class="font-bold text-slate-900 dark:text-white">{{ $sub->expires_at?->format('M d, Y') }}</span></p>
                                    @if($sub->is_active)
                                        <p class="text-[10px] text-emerald-600 font-bold mt-0.5">{{ $sub->remaining_days }} days left</p>
                                    @endif
                                </td>

                                <td class="py-3.5 px-4">
                                    @if($sub->status === 'active')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950 text-emerald-700 dark:text-emerald-400 border border-emerald-200 dark:border-emerald-800">
                                            Active
                                        </span>
                                    @elseif($sub->status === 'suspended')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-amber-50 dark:bg-amber-950 text-amber-700 dark:text-amber-400 border border-amber-200 dark:border-amber-800">
                                            Suspended
                                        </span>
                                    @elseif($sub->status === 'expired')
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-rose-50 dark:bg-rose-950 text-rose-700 dark:text-rose-400">
                                            Expired
                                        </span>
                                    @else
                                        <span class="px-2.5 py-1 rounded-full text-[10px] font-bold bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                                            Inactive
                                        </span>
                                    @endif
                                </td>

                                <td class="py-3.5 px-4 text-right">
                                    <div class="flex items-center justify-end gap-1.5">
                                        <!-- Quick Extend 1 Year -->
                                        <button type="button" 
                                                onclick="openActionModal({
                                                    actionUrl: '{{ route('admin.subscriptions.extend', $sub->id) }}',
                                                    title: 'Extend Subscription by 1 Year?',
                                                    message: 'This will add 12 months (1 Year) to {{ $sub->user->name ?? 'customer' }}\'s {{ $sub->plan_name }} subscription validity.',
                                                    btnText: 'Yes, Extend 1 Year',
                                                    type: 'blue',
                                                    icon: 'fa-solid fa-clock-rotate-left'
                                                })"
                                                class="px-2 py-1 rounded-lg bg-emerald-50 dark:bg-emerald-950/60 hover:bg-emerald-100 text-emerald-700 dark:text-emerald-300 font-bold text-[10px] border border-emerald-200 dark:border-emerald-800 cursor-pointer active:scale-95" 
                                                title="Extend 1 Year">
                                            +1 Yr
                                        </button>

                                        <!-- Suspend / Activate Toggle -->
                                        <form action="{{ route('admin.subscriptions.status', $sub->id) }}" method="POST" class="inline">
                                            @csrf
                                            <input type="hidden" name="status" value="{{ $sub->status === 'active' ? 'suspended' : 'active' }}">
                                            <button type="submit" class="p-1.5 rounded-lg text-slate-500 hover:text-amber-600 dark:hover:text-amber-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer" title="{{ $sub->status === 'active' ? 'Suspend License' : 'Activate License' }}">
                                                <i class="fa-solid {{ $sub->status === 'active' ? 'fa-pause' : 'fa-play' }} text-xs"></i>
                                            </button>
                                        </form>

                                        <a href="{{ route('admin.subscriptions.edit', $sub->id) }}" class="p-1.5 rounded-lg text-slate-500 hover:text-[#0067b8] dark:hover:text-sky-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors" title="Edit / Manage">
                                            <i class="fa-regular fa-pen-to-square text-xs"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400">
                                    No customer subscriptions found.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if($subscriptions->hasPages())
                <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                    {{ $subscriptions->links() }}
                </div>
            @endif
        </div>

    </div>

@endsection
