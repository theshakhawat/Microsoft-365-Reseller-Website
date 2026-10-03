@extends('layouts.admin.admin')

@section('title', ($role === 'admin' ? 'Administrators' : 'Customers') . ' Management | Admin Control Center')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0067b8] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span>Users</span>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 dark:text-slate-200">{{ $role === 'admin' ? 'Admins' : 'Customers' }}</span>
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

    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/80 text-red-800 dark:text-red-300 shadow-xs">
            <div class="flex items-center gap-3 mb-1">
                <i class="fa-solid fa-circle-exclamation text-red-500 text-lg"></i>
                <p class="text-xs sm:text-sm font-bold">Please correct the following:</p>
            </div>
            <ul class="list-disc list-inside text-xs space-y-0.5 ml-6">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header & Action Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl sm:text-3xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                @if($role === 'admin')
                    <span class="w-10 h-10 rounded-2xl bg-purple-100 dark:bg-purple-950/60 text-purple-600 dark:text-purple-400 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-user-shield"></i>
                    </span>
                    <span>Admin Accounts</span>
                @else
                    <span class="w-10 h-10 rounded-2xl bg-blue-100 dark:bg-blue-950/60 text-[#0067b8] dark:text-blue-400 flex items-center justify-center text-lg">
                        <i class="fa-solid fa-users"></i>
                    </span>
                    <span>Customer Accounts</span>
                @endif
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Manage account credentials, change active status, edit profile info, and assign system permissions.
            </p>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.users.create', ['role' => $role]) }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white text-xs sm:text-sm font-bold shadow-md shadow-[#0067b8]/20 active:scale-95 transition-all">
                <i class="fa-solid fa-user-plus text-xs"></i>
                <span>Add {{ $role === 'admin' ? 'Admin' : 'Customer' }}</span>
            </a>
        </div>
    </div>

    <!-- Quick Stats Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-blue-50 dark:bg-blue-950/50 text-[#0067b8] dark:text-blue-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Customers</p>
                <p class="text-lg sm:text-xl font-black text-slate-900 dark:text-white">{{ $stats['total_customers'] }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-emerald-50 dark:bg-emerald-950/50 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-user-check"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Active Customers</p>
                <p class="text-lg sm:text-xl font-black text-emerald-600 dark:text-emerald-400">{{ $stats['active_customers'] }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-purple-50 dark:bg-purple-950/50 text-purple-600 dark:text-purple-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-shield-halved"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Admins</p>
                <p class="text-lg sm:text-xl font-black text-slate-900 dark:text-white">{{ $stats['total_admins'] }}</p>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center gap-4">
            <div class="w-11 h-11 rounded-xl bg-indigo-50 dark:bg-indigo-950/50 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-lg shrink-0">
                <i class="fa-solid fa-lock"></i>
            </div>
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Active Admins</p>
                <p class="text-lg sm:text-xl font-black text-indigo-600 dark:text-indigo-400">{{ $stats['active_admins'] }}</p>
            </div>
        </div>
    </div>

    <!-- Navigation Filter Tabs & Search Controls -->
    <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-4">
        
        <!-- Role Tabs -->
        <div class="flex items-center gap-2 bg-slate-100 dark:bg-slate-800/80 p-1.5 rounded-xl">
            <a href="{{ route('admin.users.index', ['role' => 'user', 'search' => request('search')]) }}" class="px-4 py-2 rounded-lg text-xs font-bold transition-all flex items-center gap-2 {{ $role === 'user' ? 'bg-white dark:bg-slate-900 text-[#0067b8] dark:text-blue-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                <i class="fa-solid fa-user-group text-xs"></i>
                <span>Customers</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $role === 'user' ? 'bg-blue-50 text-[#0067b8] dark:bg-blue-950/60 dark:text-blue-400' : 'bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300' }}">
                    {{ $stats['total_customers'] }}
                </span>
            </a>

            <a href="{{ route('admin.users.index', ['role' => 'admin', 'search' => request('search')]) }}" class="px-4 py-2 rounded-lg text-xs font-bold transition-all flex items-center gap-2 {{ $role === 'admin' ? 'bg-white dark:bg-slate-900 text-purple-600 dark:text-purple-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900 dark:hover:text-white' }}">
                <i class="fa-solid fa-user-shield text-xs"></i>
                <span>Admins</span>
                <span class="px-2 py-0.5 rounded-full text-[10px] {{ $role === 'admin' ? 'bg-purple-50 text-purple-600 dark:bg-purple-950/60 dark:text-purple-400' : 'bg-slate-200 dark:bg-slate-700 text-slate-600 dark:text-slate-300' }}">
                    {{ $stats['total_admins'] }}
                </span>
            </a>
        </div>

        <!-- Search Form -->
        <form action="{{ route('admin.users.index') }}" method="GET" class="flex items-center gap-2 max-w-md w-full">
            <input type="hidden" name="role" value="{{ $role }}">
            <div class="relative flex-1">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400 text-xs"></i>
                <input type="text" name="search" value="{{ $search }}" placeholder="Search by name, email, or phone..." class="w-full pl-9 pr-4 py-2 text-xs rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] dark:focus:ring-blue-500">
            </div>
            @if($search)
                <a href="{{ route('admin.users.index', ['role' => $role]) }}" class="px-3 py-2 bg-slate-100 hover:bg-slate-200 dark:bg-slate-800 dark:hover:bg-slate-700 text-slate-600 dark:text-slate-300 text-xs font-bold rounded-xl transition-colors" title="Clear Search">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            @endif
            <button type="submit" class="px-4 py-2 bg-slate-900 hover:bg-slate-800 dark:bg-slate-700 dark:hover:bg-slate-600 text-white text-xs font-bold rounded-xl transition-colors shrink-0">
                Filter
            </button>
        </form>

    </div>

    <!-- Users Table Card -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
        
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/80 dark:bg-slate-800/50 border-b border-slate-200/80 dark:border-slate-800 text-[11px] font-bold text-slate-400 uppercase tracking-wider">
                        <th class="py-3.5 px-5">User</th>
                        <th class="py-3.5 px-5">Contact Details</th>
                        <th class="py-3.5 px-5 text-center">Role</th>
                        <th class="py-3.5 px-5 text-center">Status</th>
                        <th class="py-3.5 px-5 text-center">Joined Date</th>
                        <th class="py-3.5 px-5 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs">
                    @forelse($users as $user)
                        <tr class="hover:bg-slate-50/50 dark:hover:bg-slate-800/30 transition-colors">
                            
                            <!-- User Name & Avatar -->
                            <td class="py-3.5 px-5">
                                <div class="flex items-center gap-3">
                                    @if($user->photo)
                                        <img src="{{ asset($user->photo) }}" class="w-10 h-10 rounded-xl object-cover border border-slate-200 dark:border-slate-700 shrink-0" alt="{{ $user->name }}">
                                    @else
                                        <div class="w-10 h-10 rounded-xl {{ $user->role === 'admin' ? 'bg-gradient-to-tr from-purple-600 to-indigo-600' : 'bg-gradient-to-tr from-blue-600 to-cyan-600' }} text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-xs">
                                            {{ strtoupper(substr($user->name, 0, 2)) }}
                                        </div>
                                    @endif
                                    <div class="min-w-0">
                                        <p class="font-bold text-slate-900 dark:text-white truncate flex items-center gap-1.5">
                                            <span>{{ $user->name }}</span>
                                            @if(Auth::id() === $user->id)
                                                <span class="text-[10px] px-1.5 py-0.2 rounded bg-amber-100 dark:bg-amber-950/60 text-amber-700 dark:text-amber-400 font-bold">(You)</span>
                                            @endif
                                        </p>
                                        <p class="text-[11px] text-slate-500 dark:text-slate-400 truncate">{{ $user->email }}</p>
                                    </div>
                                </div>
                            </td>

                            <!-- Contact info -->
                            <td class="py-3.5 px-5">
                                <p class="text-slate-700 dark:text-slate-300 font-medium">
                                    <i class="fa-solid fa-phone text-[10px] text-slate-400 mr-1.5"></i>
                                    {{ $user->phone ?? 'Not provided' }}
                                </p>
                            </td>

                            <!-- Role Badge -->
                            <td class="py-3.5 px-5 text-center">
                                @if($user->role === 'admin')
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-purple-50 dark:bg-purple-950/60 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800/60">
                                        <i class="fa-solid fa-shield-halved text-[9px]"></i>
                                        <span>Administrator</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-blue-50 dark:bg-blue-950/60 text-blue-700 dark:text-blue-300 border border-blue-200 dark:border-blue-800/60">
                                        <i class="fa-solid fa-user text-[9px]"></i>
                                        <span>Customer</span>
                                    </span>
                                @endif
                            </td>

                            <!-- Status & Quick Toggle -->
                            <td class="py-3.5 px-5 text-center">
                                <form action="{{ route('admin.users.toggle', $user) }}" method="POST" class="inline-block">
                                    @csrf
                                    @if(Auth::id() === $user->id)
                                        <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold bg-emerald-50 dark:bg-emerald-950/60 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60 cursor-not-allowed" title="You cannot deactivate yourself">
                                            <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span>
                                            <span>Active (Self)</span>
                                        </span>
                                    @else
                                        <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1 rounded-full text-[10px] font-bold transition-all cursor-pointer {{ $user->status ? 'bg-emerald-50 hover:bg-emerald-100 dark:bg-emerald-950/60 dark:hover:bg-emerald-900/80 text-emerald-700 dark:text-emerald-300 border border-emerald-200 dark:border-emerald-800/60' : 'bg-red-50 hover:bg-red-100 dark:bg-red-950/60 dark:hover:bg-red-900/80 text-red-700 dark:text-red-300 border border-red-200 dark:border-red-800/60' }}" title="Click to toggle status">
                                            <span class="w-1.5 h-1.5 rounded-full {{ $user->status ? 'bg-emerald-500' : 'bg-red-500' }}"></span>
                                            <span>{{ $user->status ? 'Active' : 'Deactivated' }}</span>
                                        </button>
                                    @endif
                                </form>
                            </td>

                            <!-- Joined Date -->
                            <td class="py-3.5 px-5 text-center text-slate-500 dark:text-slate-400 text-[11px]">
                                {{ $user->created_at ? $user->created_at->format('M d, Y') : 'N/A' }}
                            </td>

                            <!-- Actions -->
                            <td class="py-3.5 px-5 text-right">
                                <div class="flex items-center justify-end gap-1.5">
                                    
                                    <!-- Edit Link -->
                                    <a href="{{ route('admin.users.edit', $user) }}" class="p-2 text-slate-500 hover:text-[#0067b8] dark:text-slate-400 dark:hover:text-blue-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors" title="Edit User">
                                        <i class="fa-regular fa-pen-to-square text-xs"></i>
                                    </a>

                                    <!-- Delete Button (Calls custom popup) -->
                                    @if(Auth::id() !== $user->id)
                                        <button type="button" onclick="openDeleteModal('{{ route('admin.users.destroy', $user) }}', '{{ addslashes($user->name) }}', 'Are you sure you want to permanently delete {{ addslashes($user->name) }}? This account will be removed immediately.')" class="p-2 text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/50 rounded-xl transition-colors cursor-pointer" title="Delete User">
                                            <i class="fa-regular fa-trash-can text-xs"></i>
                                        </button>
                                    @else
                                        <button type="button" disabled class="p-2 text-slate-300 dark:text-slate-700 cursor-not-allowed" title="Self-deletion is disabled">
                                            <i class="fa-regular fa-trash-can text-xs"></i>
                                        </button>
                                    @endif

                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 px-4 text-center">
                                <div class="max-w-xs mx-auto text-center space-y-3">
                                    <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center text-xl mx-auto">
                                        <i class="fa-solid fa-user-slash"></i>
                                    </div>
                                    <p class="text-sm font-bold text-slate-800 dark:text-slate-200">No {{ $role === 'admin' ? 'administrators' : 'customers' }} found</p>
                                    <p class="text-xs text-slate-400">
                                        {{ $search ? 'Try adjusting your search criteria.' : 'Click below to create your first ' . ($role === 'admin' ? 'admin' : 'customer') . ' account.' }}
                                    </p>
                                    <a href="{{ route('admin.users.create', ['role' => $role]) }}" class="inline-flex items-center gap-2 px-4 py-2 rounded-xl bg-[#0067b8] text-white text-xs font-bold shadow-sm">
                                        <i class="fa-solid fa-plus text-[10px]"></i>
                                        <span>Add New Account</span>
                                    </a>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if($users->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-900/50">
                {{ $users->links() }}
            </div>
        @endif

    </div>

</div>
@endsection
