@extends('layouts.admin.admin')

@section('title', 'Support Tickets Management | Admin Control Center')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0067b8] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 dark:text-slate-200">Support Tickets</span>
    </div>
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

    <!-- Header -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <span class="w-10 h-10 rounded-2xl bg-[#0067b8]/10 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-lg shadow-xs">
                    <i class="fa-solid fa-headset"></i>
                </span>
                <span>Customer Support Tickets</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Manage user assistance requests, reply to issues, and maintain ticket statuses.
            </p>
        </div>
    </div>

    <!-- Quick Stats Metric Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-6 gap-3.5">
        <!-- Total -->
        <a href="{{ route('admin.tickets.index') }}" class="p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs hover:border-[#0067b8]/50 transition-colors">
            <span class="text-[11px] font-bold text-slate-500 block mb-1">Total</span>
            <p class="text-xl font-black text-slate-900 dark:text-white">{{ $stats['total'] }}</p>
        </a>

        <!-- Unread by Admin -->
        <a href="{{ route('admin.tickets.index') }}" class="p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs hover:border-red-500/50 transition-colors">
            <span class="text-[11px] font-bold text-red-600 dark:text-red-400 block mb-1">New / Unread</span>
            <p class="text-xl font-black text-red-600 dark:text-red-400">{{ $stats['unread'] }}</p>
        </a>

        <!-- Open -->
        <a href="{{ route('admin.tickets.index', ['status' => 'open']) }}" class="p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs hover:border-emerald-500/50 transition-colors">
            <span class="text-[11px] font-bold text-emerald-600 dark:text-emerald-400 block mb-1">Open</span>
            <p class="text-xl font-black text-emerald-600 dark:text-emerald-400">{{ $stats['open'] }}</p>
        </a>

        <!-- Customer Reply -->
        <a href="{{ route('admin.tickets.index', ['status' => 'customer_reply']) }}" class="p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs hover:border-amber-500/50 transition-colors">
            <span class="text-[11px] font-bold text-amber-600 dark:text-amber-400 block mb-1">User Replied</span>
            <p class="text-xl font-black text-amber-600 dark:text-amber-400">{{ $stats['customer_reply'] }}</p>
        </a>

        <!-- Answered -->
        <a href="{{ route('admin.tickets.index', ['status' => 'answered']) }}" class="p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs hover:border-blue-500/50 transition-colors">
            <span class="text-[11px] font-bold text-[#0067b8] dark:text-sky-400 block mb-1">Answered</span>
            <p class="text-xl font-black text-[#0067b8] dark:text-sky-400">{{ $stats['answered'] }}</p>
        </a>

        <!-- Closed -->
        <a href="{{ route('admin.tickets.index', ['status' => 'closed']) }}" class="p-4 bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs hover:border-slate-400 transition-colors">
            <span class="text-[11px] font-bold text-slate-500 block mb-1">Closed</span>
            <p class="text-xl font-black text-slate-600 dark:text-slate-400">{{ $stats['closed'] }}</p>
        </a>
    </div>

    <!-- Filters & Search Toolbar -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 p-4 shadow-xs">
        <form action="{{ route('admin.tickets.index') }}" method="GET" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-3">
            <!-- Search -->
            <div class="relative lg:col-span-2">
                <i class="fa-solid fa-magnifying-glass absolute left-3.5 top-1/2 -translate-y-1/2 text-xs text-slate-400"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search #ID, customer, subject..." 
                       class="w-full pl-9 pr-4 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
            </div>

            <!-- Status -->
            <select name="status" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0067b8] cursor-pointer">
                <option value="">All Statuses</option>
                <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                <option value="customer_reply" {{ request('status') === 'customer_reply' ? 'selected' : '' }}>Customer Reply</option>
                <option value="answered" {{ request('status') === 'answered' ? 'selected' : '' }}>Answered</option>
                <option value="in_progress" {{ request('status') === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
            </select>

            <!-- Priority -->
            <select name="priority" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0067b8] cursor-pointer">
                <option value="">All Priorities</option>
                <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>Urgent</option>
                <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>High</option>
                <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>Medium</option>
                <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>Low</option>
            </select>

            <!-- Department -->
            <select name="department" onchange="this.form.submit()" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300 focus:outline-none focus:ring-2 focus:ring-[#0067b8] cursor-pointer">
                <option value="">All Departments</option>
                <option value="General Support" {{ request('department') === 'General Support' ? 'selected' : '' }}>General Support</option>
                <option value="Billing & Payments" {{ request('department') === 'Billing & Payments' ? 'selected' : '' }}>Billing & Payments</option>
                <option value="License & Activation" {{ request('department') === 'License & Activation' ? 'selected' : '' }}>License & Activation</option>
                <option value="Technical Issue" {{ request('department') === 'Technical Issue' ? 'selected' : '' }}>Technical Issue</option>
            </select>
        </form>
    </div>

    <!-- Tickets Table -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 shadow-xs overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse text-xs">
                <thead>
                    <tr class="border-b border-slate-100 dark:border-slate-800 bg-slate-50/75 dark:bg-slate-800/50 text-[11px] font-extrabold uppercase tracking-wider text-slate-500 dark:text-slate-400">
                        <th class="py-3.5 px-4 sm:px-6">Ticket & Subject</th>
                        <th class="py-3.5 px-4">Customer</th>
                        <th class="py-3.5 px-4">Department</th>
                        <th class="py-3.5 px-4">Priority</th>
                        <th class="py-3.5 px-4">Status</th>
                        <th class="py-3.5 px-4">Last Updated</th>
                        <th class="py-3.5 px-4 sm:px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/80">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-50/60 dark:hover:bg-slate-800/40 transition-colors {{ !$ticket->is_read_by_admin ? 'bg-amber-50/40 dark:bg-amber-950/20 font-semibold' : '' }}">
                            <!-- Ticket & Subject -->
                            <td class="py-4 px-4 sm:px-6">
                                <div class="flex items-start gap-2.5">
                                    @if(!$ticket->is_read_by_admin)
                                        <span class="w-2 h-2 rounded-full bg-red-500 mt-1.5 shrink-0 animate-pulse" title="New Activity"></span>
                                    @endif
                                    <div>
                                        <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="font-bold text-slate-900 dark:text-white hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors block text-xs sm:text-sm">
                                            {{ $ticket->subject }}
                                        </a>
                                        <div class="flex items-center gap-2 mt-1">
                                            <span class="font-mono text-[11px] font-bold text-slate-500">{{ $ticket->ticket_number }}</span>
                                            <span class="text-[10px] text-slate-400 flex items-center gap-1">
                                                <i class="fa-regular fa-comments"></i> {{ $ticket->replies()->count() }}
                                            </span>
                                        </div>
                                    </div>
                                </div>
                            </td>

                            <!-- Customer -->
                            <td class="py-4 px-4">
                                <p class="font-bold text-slate-900 dark:text-white">{{ $ticket->user->name ?? 'User #' . $ticket->user_id }}</p>
                                <p class="text-[11px] text-slate-400">{{ $ticket->user->email ?? 'N/A' }}</p>
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

                            <!-- Last Updated -->
                            <td class="py-4 px-4 text-slate-500 text-[11px]">
                                {{ $ticket->last_reply_at ? $ticket->last_reply_at->diffForHumans() : $ticket->created_at->diffForHumans() }}
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-4 sm:px-6 text-right">
                                <div class="flex items-center justify-end gap-2">
                                    <a href="{{ route('admin.tickets.show', $ticket->id) }}" class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-[#0067b8] dark:text-sky-400 hover:bg-[#0067b8] hover:text-white transition-colors" title="View & Reply">
                                        <i class="fa-solid fa-reply text-xs"></i>
                                    </a>

                                    <button type="button" 
                                            onclick="openDeleteModal('{{ route('admin.tickets.destroy', $ticket->id) }}', 'Ticket #{{ $ticket->ticket_number }}', 'Are you sure you want to permanently delete Ticket #{{ $ticket->ticket_number }} along with all replies and attachments?')" 
                                            class="p-2 rounded-xl bg-slate-100 dark:bg-slate-800 text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/40 transition-colors cursor-pointer" 
                                            title="Delete Ticket">
                                        <i class="fa-solid fa-trash-can text-xs"></i>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="py-12 text-center text-slate-400 dark:text-slate-500">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center mx-auto mb-3 text-xl">
                                    <i class="fa-solid fa-headset"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-300">No support tickets found</p>
                                <p class="text-xs mt-1">Customer support inquiries will appear here.</p>
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
