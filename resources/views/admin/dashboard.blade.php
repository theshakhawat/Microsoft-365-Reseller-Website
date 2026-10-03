@extends('layouts.admin.admin')

@section('title', 'Admin Command Center | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white flex items-center gap-2">
        <span>Dashboard</span>
        <span class="text-[10px] font-bold uppercase tracking-wider bg-red-100 dark:bg-red-950/70 text-red-600 dark:text-red-400 border border-red-200 dark:border-red-900/60 px-2 py-0.5 rounded-full">
            Live Control
        </span>
    </span>
@endsection

@section('content')

    <!-- Executive Greeting Banner -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-gradient-to-r from-slate-900 via-slate-800 to-indigo-950 rounded-3xl p-6 sm:p-8 text-white shadow-xl shadow-slate-900/10">
        <div class="space-y-1">
            <span class="text-xs font-bold uppercase tracking-wider text-purple-400 flex items-center gap-1.5">
                <i class="fa-solid fa-crown text-xs"></i> Super Admin Portal
            </span>
            <h2 class="text-xl sm:text-2xl lg:text-3xl font-black tracking-tight">
                Welcome, {{ $user->name }}
            </h2>
            <p class="text-xs sm:text-sm text-slate-300 max-w-xl">
                Overview of Microsoft 365 license distribution, revenue, and active customer accounts.
            </p>
        </div>
        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('home') }}#plans" target="_blank" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 transition-all shadow-md active:scale-95">
                <i class="fa-solid fa-plus text-xs"></i>
                <span>New License Order</span>
            </a>
        </div>
    </div>

    <!-- 4 Metric Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-6">
        
        <!-- Stat 1: Total Customers -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-sm hover:border-sky-300 dark:hover:border-sky-800 transition-all">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Total Customers</p>
                <div class="w-11 h-11 rounded-2xl bg-sky-50 dark:bg-sky-950/60 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-lg shadow-xs">
                    <i class="fa-solid fa-users"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900 dark:text-white mt-3">{{ $stats['total_users'] }}</p>
            <div class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400 font-bold mt-2">
                <i class="fa-solid fa-arrow-trend-up"></i>
                <span>Registered in platform</span>
            </div>
        </div>

        <!-- Stat 2: Active Licenses -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-sm hover:border-emerald-300 dark:hover:border-emerald-800 transition-all">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Active Licenses</p>
                <div class="w-11 h-11 rounded-2xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg shadow-xs">
                    <i class="fa-solid fa-shield-check"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900 dark:text-white mt-3">{{ $stats['active_licenses'] }}</p>
            <div class="flex items-center gap-1.5 text-xs text-slate-500 dark:text-slate-400 font-semibold mt-2">
                <span>Provisioned CSP seats</span>
            </div>
        </div>

        <!-- Stat 3: Monthly Volume -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-sm hover:border-purple-300 dark:hover:border-purple-800 transition-all">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Monthly Volume</p>
                <div class="w-11 h-11 rounded-2xl bg-purple-50 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-lg shadow-xs">
                    <i class="fa-solid fa-bangladeshi-taka-sign"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900 dark:text-white mt-3">৳{{ number_format($stats['monthly_revenue']) }}</p>
            <div class="flex items-center gap-1.5 text-xs text-emerald-600 dark:text-emerald-400 font-bold mt-2">
                <i class="fa-solid fa-arrow-trend-up"></i>
                <span>bKash & Nagad verified</span>
            </div>
        </div>

        <!-- Stat 4: Pending Orders -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-sm hover:border-amber-300 dark:hover:border-amber-800 transition-all">
            <div class="flex items-center justify-between">
                <p class="text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Pending Orders</p>
                <div class="w-11 h-11 rounded-2xl bg-amber-50 dark:bg-amber-950/60 text-amber-600 dark:text-amber-400 flex items-center justify-center text-lg shadow-xs">
                    <i class="fa-solid fa-clock"></i>
                </div>
            </div>
            <p class="text-3xl font-black text-slate-900 dark:text-white mt-3">{{ $stats['pending_orders'] }}</p>
            <div class="flex items-center gap-1.5 text-xs text-amber-600 dark:text-amber-400 font-bold mt-2">
                <i class="fa-solid fa-triangle-exclamation"></i>
                <span>Awaiting verification</span>
            </div>
        </div>

    </div>

    <!-- Recent Registered Users Table -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-7 shadow-sm">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h3 class="text-base sm:text-lg font-extrabold text-slate-900 dark:text-white">Registered Customer Accounts</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 mt-0.5">Real-time user registry from database.</p>
            </div>
            <span class="text-xs font-bold bg-slate-100 dark:bg-slate-800 text-slate-700 dark:text-slate-300 px-3.5 py-1.5 rounded-xl self-start sm:self-auto">
                Total: {{ count($recentUsers) }} Records
            </span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-xs">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-slate-800 text-slate-400 dark:text-slate-500 font-bold uppercase tracking-wider text-[10px]">
                        <th class="pb-3.5">User Profile</th>
                        <th class="pb-3.5">Phone Contact</th>
                        <th class="pb-3.5">System Role</th>
                        <th class="pb-3.5">Account Status</th>
                        <th class="pb-3.5">Joined Date</th>
                        <th class="pb-3.5 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800 text-slate-700 dark:text-slate-300">
                    @forelse ($recentUsers as $u)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            <td class="py-4 font-semibold text-slate-900 dark:text-white flex items-center gap-3">
                                @if($u->photo)
                                    <img src="{{ asset($u->photo) }}" class="w-9 h-9 rounded-xl object-cover border border-slate-200 dark:border-slate-700 shrink-0" alt="{{ $u->name }}" />
                                @else
                                    <div class="w-9 h-9 rounded-xl bg-slate-100 dark:bg-slate-800 border border-slate-200 dark:border-slate-700 text-[#0067b8] dark:text-sky-400 font-bold text-xs flex items-center justify-center shrink-0">
                                        {{ strtoupper(substr($u->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-bold text-slate-900 dark:text-white">{{ $u->name }}</p>
                                    <p class="text-[11px] text-slate-400 dark:text-slate-500 font-normal">{{ $u->email }}</p>
                                </div>
                            </td>
                            <td class="py-4 text-slate-600 dark:text-slate-400 font-mono">
                                {{ $u->phone ?? 'N/A' }}
                            </td>
                            <td class="py-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold uppercase {{ $u->role === 'admin' ? 'bg-purple-100 text-purple-700 border border-purple-200 dark:bg-purple-950/60 dark:text-purple-300 dark:border-purple-800' : 'bg-sky-50 text-[#0067b8] border border-sky-100 dark:bg-sky-950/60 dark:text-sky-300 dark:border-sky-800' }}">
                                    {{ $u->role }}
                                </span>
                            </td>
                            <td class="py-4">
                                @if ($u->status)
                                    <span class="inline-flex items-center gap-1.5 text-emerald-700 dark:text-emerald-400 font-bold text-[11px]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Active
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1.5 text-red-600 dark:text-red-400 font-bold text-[11px]">
                                        <span class="w-1.5 h-1.5 rounded-full bg-red-500"></span> Deactivated
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 text-slate-500 dark:text-slate-400">
                                {{ $u->created_at->format('M d, Y') }}
                            </td>
                            <td class="py-4 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.users.edit', $u) }}" class="text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:underline px-2 py-1 rounded">
                                        Edit
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-8 text-center text-slate-400 dark:text-slate-500">
                                No accounts registered yet.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
