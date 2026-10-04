@extends('layouts.user.user')

@section('title', 'My Support Tickets | User Portal')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Support Tickets</span>
@endsection

@section('content')
<div class="space-y-6">

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/80 text-emerald-800 dark:text-emerald-300 flex items-center justify-between shadow-xs">
            <div class="flex items-center gap-3">
                <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 text-lg"></i>
                <p class="text-xs sm:text-sm font-bold">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/80 text-red-800 dark:text-red-300 flex items-center gap-3 shadow-xs">
            <i class="fa-solid fa-circle-exclamation text-red-600 dark:text-red-400 text-lg"></i>
            <p class="text-xs sm:text-sm font-bold">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Header & Action -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <span class="w-10 h-10 rounded-2xl bg-[#0067b8]/10 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-lg shadow-xs">
                    <i class="fa-solid fa-headset"></i>
                </span>
                <span>Customer Support Center</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Open a ticket for license keys, payment verification, activation help, or general inquiries.
            </p>
        </div>

        <a href="{{ route('user.tickets.create') }}" class="px-5 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white text-xs sm:text-sm font-bold shadow-md shadow-[#0067b8]/20 active:scale-95 transition-all flex items-center justify-center gap-2">
            <i class="fa-solid fa-plus text-xs"></i>
            <span>Open New Ticket</span>
        </a>
    </div>

    <!-- Quick Stats Metric Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
        <!-- Total -->
        <a href="{{ route('user.tickets') }}" class="p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs hover:border-[#0067b8]/50 transition-colors">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500">Total Tickets</span>
                <span class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-ticket"></i>
                </span>
            </div>
            <p class="text-xl font-black text-slate-900 dark:text-white">{{ $stats['total'] }}</p>
        </a>

        <!-- Open / Active -->
        <a href="{{ route('user.tickets', ['status' => 'open']) }}" class="p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs hover:border-emerald-500/50 transition-colors">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-emerald-600 dark:text-emerald-400">Open / Awaiting</span>
                <span class="w-8 h-8 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-circle-dot"></i>
                </span>
            </div>
            <p class="text-xl font-black text-emerald-600 dark:text-emerald-400">{{ $stats['open'] }}</p>
        </a>

        <!-- Answered -->
        <a href="{{ route('user.tickets', ['status' => 'answered']) }}" class="p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs hover:border-blue-500/50 transition-colors">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-[#0067b8] dark:text-sky-400">Staff Answered</span>
                <span class="w-8 h-8 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-reply-all"></i>
                </span>
            </div>
            <p class="text-xl font-black text-[#0067b8] dark:text-sky-400">{{ $stats['answered'] }}</p>
        </a>

        <!-- Closed -->
        <a href="{{ route('user.tickets', ['status' => 'closed']) }}" class="p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs hover:border-slate-400 transition-colors">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold text-slate-500">Resolved / Closed</span>
                <span class="w-8 h-8 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-500 flex items-center justify-center text-xs">
                    <i class="fa-solid fa-circle-check"></i>
                </span>
            </div>
            <p class="text-xl font-black text-slate-600 dark:text-slate-400">{{ $stats['closed'] }}</p>
        </a>
    </div>

    <!-- Filter & Search Toolbar -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 p-4 shadow-xs">
        <form action="{{ route('user.tickets') }}" method="GET" class="flex flex-col sm:flex-row items-center gap-3">
            <div class="relative flex-1 w-full">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search ticket by #ID or subject..." 
                       class="w-full pl-9 pr-4 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
            </div>

            <select name="status" onchange="this.form.submit()" class="w-full sm:w-44 px-3 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0067b8] cursor-pointer">
                <option value="">All Statuses</option>
                <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                <option value="answered" {{ request('status') === 'answered' ? 'selected' : '' }}>Staff Answered</option>
                <option value="customer_reply" {{ request('status') === 'customer_reply' ? 'selected' : '' }}>Customer Reply</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
            </select>

            @if(request('search') || request('status'))
                <a href="{{ route('user.tickets') }}" class="px-3 py-2.5 rounded-xl text-xs font-bold text-slate-500 hover:text-red-500 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                    Reset
                </a>
            @endif
        </form>
    </div>

    <!-- Tickets List Table / Cards -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/75 dark:bg-slate-800/50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="py-3.5 px-4 sm:px-6">Ticket ID & Subject</th>
                        <th class="py-3.5 px-4">Department</th>
                        <th class="py-3.5 px-4">Priority</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Last Activity</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Action</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors {{ !$ticket->is_read_by_user ? 'bg-blue-50/30 dark:bg-blue-950/20 font-semibold' : '' }}">
                            <!-- Ticket ID & Subject -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="flex items-start gap-2.5">
                                    @if(!$ticket->is_read_by_user)
                                        <span class="w-2 h-2 rounded-full bg-blue-600 mt-1.5 shrink-0 animate-ping" title="Unread Response"></span>
                                    @endif
                                    <div>
                                        <a href="{{ route('user.tickets.show', $ticket->id) }}" class="font-bold text-slate-900 dark:text-white hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors block text-xs sm:text-sm">
                                            {{ $ticket->subject }}
                                        </a>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="font-mono text-[11px] font-bold text-slate-500">{{ $ticket->ticket_number }}</span>
                                            @if($ticket->replies()->count() > 0)
                                                <span class="text-[10px] text-slate-400 flex items-center gap-1">
                                                    <i class="fa-regular fa-comments"></i> {{ $ticket->replies()->count() }} replies
                                                </span>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Department -->
                            <td class="py-4 px-4 text-slate-700 dark:text-slate-300 font-medium">
                                {{ $ticket->department }}
                            </td>

                            <!-- Priority -->
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border uppercase tracking-wider {{ $ticket->priority_badge }}">
                                    {{ $ticket->priority }}
                                </span>
                            </td>

                            <!-- Status -->
                            <td class="py-4 px-4">
                                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border uppercase tracking-wider {{ $ticket->status_badge }}">
                                    {{ str_replace('_', ' ', $ticket->status) }}
                                </span>
                            </td>

                            <!-- Last Activity -->
                            <td class="py-4 px-4 text-slate-500 text-[11px]">
                                {{ $ticket->last_reply_at ? $ticket->last_reply_at->diffForHumans() : $ticket->created_at->diffForHumans() }}
                            </td>

                            <!-- Action -->
                            <td class="py-4 px-4 sm:px-6 text-right">
                                <a href="{{ route('user.tickets.show', $ticket->id) }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-xl bg-slate-100 dark:bg-slate-800 text-[#0067b8] dark:text-sky-400 hover:bg-[#0067b8] hover:text-white font-bold transition-all">
                                    <span>View & Reply</span>
                                    <i class="fa-solid fa-arrow-right text-[10px]"></i>
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 dark:text-slate-500">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mx-auto mb-3 text-xl">
                                    <i class="fa-solid fa-headset"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-300">No support tickets found</p>
                                <p class="text-xs mt-1">Need help? Open a new ticket anytime and our support team will assist you.</p>
                                <a href="{{ route('user.tickets.create') }}" class="inline-block mt-4 px-4 py-2 rounded-xl bg-[#0067b8] text-white font-bold text-xs shadow-xs">
                                    Create First Ticket
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($tickets->hasPages())
            <div class="p-4 border-t border-slate-100 dark:border-slate-800">
                {{ $tickets->links() }}
            </div>
        @endif
    </div>

</div>
@endsection
