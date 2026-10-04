@extends('layouts.admin.admin')

@section('title', 'Ticket #' . $ticket->ticket_number . ': ' . $ticket->subject . ' | Admin Control Center')

@section('breadcrumb')
    <div class="flex items-center gap-2 text-xs font-semibold text-slate-500 dark:text-slate-400">
        <a href="{{ route('admin.dashboard') }}" class="hover:text-[#0067b8] transition-colors">Dashboard</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <a href="{{ route('admin.tickets.index') }}" class="hover:text-[#0067b8] transition-colors">Support Tickets</a>
        <i class="fa-solid fa-chevron-right text-[10px]"></i>
        <span class="text-slate-800 dark:text-slate-200">#{{ $ticket->ticket_number }}</span>
    </div>
@endsection

@section('content')
<div class="space-y-6 max-w-5xl mx-auto">

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/80 text-emerald-800 dark:text-emerald-300 flex items-center gap-3 shadow-xs">
            <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 text-lg"></i>
            <p class="text-xs sm:text-sm font-bold">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Top Ticket Header & Status Manager Bar -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs flex flex-col md:flex-row md:items-center justify-between gap-5">
        <div class="space-y-2">
            <div class="flex items-center gap-2.5 flex-wrap">
                <span class="font-mono text-xs font-black px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200">
                    {{ $ticket->ticket_number }}
                </span>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border uppercase tracking-wider {{ $ticket->status_badge }}">
                    Status: {{ str_replace('_', ' ', $ticket->status) }}
                </span>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border uppercase tracking-wider {{ $ticket->priority_badge }}">
                    Priority: {{ $ticket->priority }}
                </span>
                <span class="text-xs text-slate-500 font-semibold flex items-center gap-1.5">
                    <i class="fa-solid fa-folder text-slate-400"></i> {{ $ticket->department }}
                </span>
            </div>

            <h1 class="text-lg sm:text-xl font-black text-slate-900 dark:text-white tracking-tight">
                {{ $ticket->subject }}
            </h1>

            <div class="flex items-center gap-3 text-xs text-slate-500 flex-wrap">
                <span>Customer: <strong class="text-slate-800 dark:text-slate-200">{{ $ticket->user->name ?? 'User #' . $ticket->user_id }}</strong> ({{ $ticket->user->email ?? 'N/A' }})</span>
                <span>•</span>
                <span>Created: {{ $ticket->created_at->format('M d, Y • h:i A') }}</span>
            </div>
        </div>

        <!-- Quick Status & Priority Updater Form -->
        <div class="p-4 rounded-2xl bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 space-y-3 shrink-0">
            <form action="{{ route('admin.tickets.status', $ticket->id) }}" method="POST" class="flex flex-col sm:flex-row items-center gap-2">
                @csrf
                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Update Status</label>
                    <select name="status" class="px-3 py-1.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                        <option value="open" {{ $ticket->status === 'open' ? 'selected' : '' }}>Open</option>
                        <option value="answered" {{ $ticket->status === 'answered' ? 'selected' : '' }}>Answered</option>
                        <option value="customer_reply" {{ $ticket->status === 'customer_reply' ? 'selected' : '' }}>Customer Reply</option>
                        <option value="in_progress" {{ $ticket->status === 'in_progress' ? 'selected' : '' }}>In Progress</option>
                        <option value="closed" {{ $ticket->status === 'closed' ? 'selected' : '' }}>Closed</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-slate-400 uppercase mb-1">Priority</label>
                    <select name="priority" class="px-3 py-1.5 rounded-xl bg-white dark:bg-slate-900 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                        <option value="low" {{ $ticket->priority === 'low' ? 'selected' : '' }}>Low</option>
                        <option value="medium" {{ $ticket->priority === 'medium' ? 'selected' : '' }}>Medium</option>
                        <option value="high" {{ $ticket->priority === 'high' ? 'selected' : '' }}>High</option>
                        <option value="urgent" {{ $ticket->priority === 'urgent' ? 'selected' : '' }}>Urgent</option>
                    </select>
                </div>

                <button type="submit" class="mt-4 sm:mt-5 px-3.5 py-1.5 rounded-xl bg-slate-800 text-white dark:bg-white dark:text-slate-900 text-xs font-bold hover:bg-black dark:hover:bg-slate-200 transition-colors cursor-pointer">
                    Save
                </button>
            </form>
        </div>
    </div>

    <!-- Conversation Feed -->
    <div class="space-y-4">

        <!-- Initial User Query Card -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs space-y-3">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#0067b8] to-sky-400 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                        {{ strtoupper(substr($ticket->user->name ?? 'U', 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-900 dark:text-white">{{ $ticket->user->name ?? 'User #' . $ticket->user_id }} <span class="text-[10px] text-slate-400 font-normal">({{ $ticket->user->email ?? 'N/A' }})</span></p>
                        <p class="text-[10px] text-slate-400">{{ $ticket->created_at->format('M d, Y • h:i A') }}</p>
                    </div>
                </div>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                    Customer Initial Query
                </span>
            </div>

            <div class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 whitespace-pre-line leading-relaxed">
                {{ $ticket->message }}
            </div>

            @if($ticket->attachment)
                <div class="pt-3 border-t border-slate-100 dark:border-slate-800">
                    <a href="{{ asset($ticket->attachment) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:bg-blue-50 dark:hover:bg-blue-950/40 transition-colors">
                        <i class="fa-solid fa-paperclip"></i>
                        <span>View Attachment</span>
                        <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                    </a>
                </div>
            @endif
        </div>

        <!-- Replies List -->
        @foreach($ticket->replies as $reply)
            <div class="bg-white dark:bg-slate-900 rounded-3xl border {{ $reply->is_admin_reply ? 'border-[#0067b8]/30 dark:border-[#0067b8]/40 ring-1 ring-[#0067b8]/20 bg-blue-50/20 dark:bg-blue-950/10' : 'border-slate-200/90 dark:border-slate-800' }} p-6 shadow-xs space-y-3">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                    <div class="flex items-center gap-3">
                        @if($reply->is_admin_reply)
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-600 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                                <i class="fa-solid fa-headset text-xs"></i>
                            </div>
                        @else
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#0067b8] to-sky-400 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                                {{ strtoupper(substr($reply->user->name ?? 'U', 0, 1)) }}
                            </div>
                        @endif

                        <div>
                            <p class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <span>{{ $reply->user->name ?? 'User' }}</span>
                                @if($reply->is_admin_reply)
                                    <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-purple-100 dark:bg-purple-950 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                        Support Admin
                                    </span>
                                @else
                                    <span class="text-[10px] font-bold text-slate-400">(Customer)</span>
                                @endif
                            </p>
                            <p class="text-[10px] text-slate-400">{{ $reply->created_at->format('M d, Y • h:i A') }} ({{ $reply->created_at->diffForHumans() }})</p>
                        </div>
                    </div>
                </div>

                <div class="text-xs sm:text-sm text-slate-700 dark:text-slate-300 whitespace-pre-line leading-relaxed">
                    {{ $reply->message }}
                </div>

                @if($reply->attachment)
                    <div class="pt-3 border-t border-slate-100 dark:border-slate-800">
                        <a href="{{ asset($reply->attachment) }}" target="_blank" class="inline-flex items-center gap-2 px-3 py-1.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs font-bold text-[#0067b8] dark:text-sky-400 hover:bg-blue-50 dark:hover:bg-blue-950/40 transition-colors">
                            <i class="fa-solid fa-paperclip"></i>
                            <span>View Attachment</span>
                            <i class="fa-solid fa-arrow-up-right-from-square text-[10px]"></i>
                        </a>
                    </div>
                @endif
            </div>
        @endforeach

    </div>

    <!-- Admin Reply Form -->
    <form action="{{ route('admin.tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-xs space-y-5">
        @csrf
        <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
            <h3 class="text-sm font-black uppercase tracking-wider text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-reply-all text-[#0067b8] dark:text-sky-400"></i>
                Reply to Customer
            </h3>
            <span class="text-[11px] text-slate-400">Customer will be notified with unread status badge in their portal.</span>
        </div>

        <div>
            <textarea name="message" 
                      rows="5" 
                      required 
                      placeholder="Write your official response to customer here..." 
                      class="w-full px-4 py-3 rounded-2xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs sm:text-sm text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all"></textarea>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <!-- Set Status After Reply -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Set Ticket Status</label>
                <select name="status" class="w-full px-3 py-2 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0067b8]">
                    <option value="answered" selected>Mark as Answered (Customer pending review)</option>
                    <option value="in_progress">Mark as In Progress</option>
                    <option value="closed">Mark as Closed / Resolved</option>
                </select>
            </div>

            <!-- Attachment -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1">Attach Document / File <span class="text-slate-400 text-[10px] font-normal">(Optional)</span></label>
                <input type="file" 
                       name="attachment" 
                       accept="image/*,.pdf,.zip,.doc,.docx"
                       class="w-full text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 dark:file:bg-slate-800 file:text-slate-700 dark:file:text-slate-300 hover:file:bg-slate-200 file:cursor-pointer">
            </div>
        </div>

        <div class="flex items-center justify-end gap-3 pt-2">
            <a href="{{ route('admin.tickets.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                Back to Tickets List
            </a>
            <button type="submit" class="px-7 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white text-xs sm:text-sm font-bold shadow-md shadow-[#0067b8]/20 active:scale-95 transition-all flex items-center justify-center gap-2 cursor-pointer">
                <i class="fa-solid fa-paper-plane text-xs"></i>
                <span>Submit Official Reply</span>
            </button>
        </div>
    </form>

</div>
@endsection
