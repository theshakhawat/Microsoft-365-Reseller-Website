@extends('layouts.user.user')

@section('title', 'My Notifications | User Portal')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Notifications</span>
@endsection

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/80 text-emerald-800 dark:text-emerald-300 flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 text-lg"></i>
                <p class="text-xs sm:text-sm font-bold">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    <!-- Header & Bulk Actions -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <span class="w-10 h-10 rounded-2xl bg-[#0067b8]/10 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-lg shadow-xs">
                    <i class="fa-solid fa-bell"></i>
                </span>
                <span>My Notifications</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Stay updated on your license activations, support ticket replies, and payments.
            </p>
        </div>

        <div class="flex items-center gap-2.5 flex-wrap">
            @if($unreadCount > 0)
                <button type="button" 
                        onclick="openUserActionModal({
                            actionUrl: '{{ route('user.notifications.mark-all-read') }}',
                            title: 'Mark All as Read?',
                            message: 'Do you want to mark all {{ $unreadCount }} unread notifications as read?',
                            btnText: 'Mark All Read',
                            type: 'blue',
                            icon: 'fa-solid fa-check-double'
                        })"
                        class="px-4 py-2.5 rounded-xl bg-slate-100 dark:bg-slate-800 hover:bg-slate-200 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs">
                    <i class="fa-solid fa-check-double text-xs"></i>
                    <span>Mark All Read</span>
                </button>
            @endif

            @if($totalCount > 0)
                <button type="button" 
                        onclick="openUserActionModal({
                            actionUrl: '{{ route('user.notifications.delete-all') }}',
                            title: 'Clear All Notifications?',
                            message: 'Are you sure you want to delete all your notifications? This cannot be undone.',
                            btnText: 'Yes, Clear All',
                            type: 'rose',
                            icon: 'fa-solid fa-trash-can'
                        })"
                        class="px-4 py-2.5 rounded-xl border border-rose-200 dark:border-rose-900/60 hover:bg-rose-50 dark:hover:bg-rose-950/40 text-rose-600 dark:text-rose-400 text-xs font-bold transition-all cursor-pointer flex items-center gap-1.5 shadow-xs">
                    <i class="fa-solid fa-trash-can text-xs"></i>
                    <span>Clear All</span>
                </button>
            @endif
        </div>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 p-4 shadow-xs">
        <form action="{{ route('user.notifications') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search in your alerts..." 
                       class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
            </div>

            <select name="status" onchange="this.form.submit()" class="w-full sm:w-40 px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0067b8] cursor-pointer">
                <option value="">All Statuses</option>
                <option value="unread" {{ request('status') === 'unread' ? 'selected' : '' }}>Unread Only ({{ $unreadCount }})</option>
                <option value="read" {{ request('status') === 'read' ? 'selected' : '' }}>Read Only</option>
            </select>

            <select name="type" onchange="this.form.submit()" class="w-full sm:w-40 px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0067b8] cursor-pointer">
                <option value="">All Types</option>
                <option value="ticket" {{ request('type') === 'ticket' ? 'selected' : '' }}>Support Tickets</option>
                <option value="subscription" {{ request('type') === 'subscription' ? 'selected' : '' }}>Subscriptions</option>
                <option value="order" {{ request('type') === 'order' ? 'selected' : '' }}>Orders</option>
                <option value="payment" {{ request('type') === 'payment' ? 'selected' : '' }}>Payments</option>
            </select>

            @if(request('search') || request('status') || request('type'))
                <a href="{{ route('user.notifications') }}" class="px-3 py-2 rounded-xl text-xs font-bold text-slate-500 hover:text-red-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Notifications List -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xs divide-y divide-slate-100 dark:divide-slate-800 overflow-hidden">
        @forelse($notifications as $notif)
            <div class="p-4 sm:p-5 flex items-start justify-between gap-4 hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors {{ !$notif->is_read ? 'bg-blue-50/20 dark:bg-blue-950/15' : '' }}">
                <div class="flex items-start gap-3.5 flex-1 min-w-0">
                    <!-- Icon -->
                    <div class="w-10 h-10 rounded-2xl flex items-center justify-center shrink-0 text-base shadow-xs mt-0.5
                        @if($notif->color === 'emerald') bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 border border-emerald-200 dark:border-emerald-800
                        @elseif($notif->color === 'amber') bg-amber-50 dark:bg-amber-950/60 text-amber-600 border border-amber-200 dark:border-amber-800
                        @elseif($notif->color === 'rose') bg-rose-50 dark:bg-rose-950/60 text-rose-600 border border-rose-200 dark:border-rose-800
                        @elseif($notif->color === 'purple') bg-purple-50 dark:bg-purple-950/60 text-purple-600 border border-purple-200 dark:border-purple-800
                        @else bg-blue-50 dark:bg-blue-950/60 text-[#0067b8] dark:text-sky-400 border border-blue-200 dark:border-blue-800 @endif">
                        <i class="{{ $notif->icon ?: 'fa-solid fa-bell' }}"></i>
                    </div>

                    <!-- Details -->
                    <div class="flex-1 min-w-0 space-y-1">
                        <div class="flex items-center gap-2 flex-wrap">
                            <h4 class="font-bold text-slate-900 dark:text-white text-xs sm:text-sm">
                                {{ $notif->title }}
                            </h4>
                            @if(!$notif->is_read)
                                <span class="px-2 py-0.5 rounded-full text-[9px] font-black bg-blue-100 dark:bg-blue-950 text-[#0067b8] dark:text-sky-300">
                                    NEW
                                </span>
                            @endif
                            <span class="text-[10px] text-slate-400">
                                • {{ $notif->created_at->diffForHumans() }} ({{ $notif->created_at->format('M d, Y • h:i A') }})
                            </span>
                        </div>

                        <p class="text-xs text-slate-600 dark:text-slate-300 leading-relaxed">
                            {{ $notif->message }}
                        </p>

                        @if($notif->action_url)
                            <div class="pt-1.5">
                                <a href="{{ route('user.notifications.read-and-redirect', $notif->id) }}" class="inline-flex items-center gap-1.5 text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:underline">
                                    <span>View Details</span>
                                    <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                                </a>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Item Actions (Toggle Read & Delete) -->
                <div class="flex items-center gap-1.5 shrink-0">
                    <!-- Toggle Read -->
                    <form action="{{ route('user.notifications.toggle-read', $notif->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-slate-700 dark:hover:text-slate-200 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer" title="{{ $notif->is_read ? 'Mark as Unread' : 'Mark as Read' }}">
                            <i class="fa-solid {{ $notif->is_read ? 'fa-envelope' : 'fa-envelope-open' }} text-xs"></i>
                        </button>
                    </form>

                    <!-- Delete -->
                    <form action="{{ route('user.notifications.destroy', $notif->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/40 transition-colors cursor-pointer" title="Delete">
                            <i class="fa-solid fa-trash-can text-xs"></i>
                        </button>
                    </form>
                </div>
            </div>
        @empty
            <div class="p-12 text-center text-slate-400 dark:text-slate-500 space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mx-auto text-xl">
                    <i class="fa-regular fa-bell-slash"></i>
                </div>
                <p class="text-sm font-bold text-slate-700 dark:text-slate-300">No notifications found</p>
                <p class="text-xs">Your account alerts will appear here.</p>
            </div>
        @endforelse
    </div>

    @if($notifications->hasPages())
        <div class="p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800">
            {{ $notifications->links() }}
        </div>
    @endif

</div>
@endsection
