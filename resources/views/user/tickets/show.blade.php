@extends('layouts.user.user')

@section('title', 'Ticket #' . $ticket->ticket_number . ': ' . $ticket->subject . ' | User Portal')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('user.tickets') }}" class="text-slate-500 hover:text-[#0067b8]">Support Tickets</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">#{{ $ticket->ticket_number }}</span>
@endsection

@section('content')
<div class="space-y-6 max-w-4xl mx-auto">

    <!-- Flash Messages -->
    @if(session('success'))
        <div class="p-4 rounded-2xl bg-emerald-50 dark:bg-emerald-950/40 border border-emerald-200 dark:border-emerald-800/80 text-emerald-800 dark:text-emerald-300 flex items-center gap-3 shadow-xs">
            <i class="fa-solid fa-circle-check text-emerald-600 dark:text-emerald-400 text-lg"></i>
            <p class="text-xs sm:text-sm font-bold">{{ session('success') }}</p>
        </div>
    @endif

    @if(session('error'))
        <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/80 text-red-800 dark:text-red-300 flex items-center gap-3 shadow-xs">
            <i class="fa-solid fa-circle-exclamation text-red-600 dark:text-red-400 text-lg"></i>
            <p class="text-xs sm:text-sm font-bold">{{ session('error') }}</p>
        </div>
    @endif

    <!-- Ticket Top Info Bar -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5 flex-wrap mb-2">
                <span class="font-mono text-xs font-black px-2.5 py-1 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200">
                    {{ $ticket->ticket_number }}
                </span>
                <span class="px-2.5 py-1 rounded-full text-[10px] font-bold border uppercase tracking-wider {{ $ticket->status_badge }}">
                    {{ str_replace('_', ' ', $ticket->status) }}
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
            <p class="text-[11px] text-slate-400 mt-1">
                Opened {{ $ticket->created_at->format('M d, Y h:i A') }} • Last active {{ $ticket->last_reply_at ? $ticket->last_reply_at->diffForHumans() : $ticket->created_at->diffForHumans() }}
            </p>
        </div>

        <div class="flex items-center gap-2.5 self-start sm:self-center">
            <a href="{{ route('user.tickets') }}" class="px-3.5 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-left mr-1"></i> All Tickets
            </a>

            @if($ticket->status !== 'closed')
                <button type="button" 
                        onclick="openUserActionModal({
                            actionUrl: '{{ route('user.tickets.close', $ticket->id) }}',
                            title: 'Close Ticket #{{ $ticket->ticket_number }}?',
                            message: 'Are you sure you want to mark this support ticket as resolved and closed?',
                            btnText: 'Yes, Close Ticket',
                            type: 'rose',
                            icon: 'fa-solid fa-lock'
                        })"
                        class="px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-600 dark:text-slate-400 hover:text-red-600 hover:bg-red-50 dark:hover:bg-red-950/40 transition-colors cursor-pointer">
                    <i class="fa-solid fa-lock text-xs mr-1"></i> Close Ticket
                </button>
            @endif
        </div>
    </div>

    <!-- Conversation Feed -->
    <div class="space-y-4">

        <!-- Initial User Query Card -->
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs space-y-3">
            <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#0067b8] to-sky-400 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                        {{ strtoupper(substr($ticket->user->name, 0, 1)) }}
                    </div>
                    <div>
                        <p class="text-xs font-bold text-slate-900 dark:text-white">{{ $ticket->user->name }} <span class="text-[10px] text-slate-400 font-normal">(Author)</span></p>
                        <p class="text-[10px] text-slate-400">{{ $ticket->created_at->format('M d, Y • h:i A') }}</p>
                    </div>
                </div>
                <span class="text-[10px] font-bold px-2 py-0.5 rounded-full bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-400">
                    Original Request
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
            <div class="bg-white dark:bg-slate-900 rounded-3xl border {{ $reply->is_admin_reply ? 'border-[#0067b8]/30 dark:border-[#0067b8]/40 ring-1 ring-[#0067b8]/20' : 'border-slate-200/90 dark:border-slate-800' }} p-6 shadow-xs space-y-3">
                <div class="flex items-center justify-between border-b border-slate-100 dark:border-slate-800 pb-3">
                    <div class="flex items-center gap-3">
                        @if($reply->is_admin_reply)
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-purple-600 to-indigo-600 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                                <i class="fa-solid fa-headset text-xs"></i>
                            </div>
                        @else
                            <div class="w-9 h-9 rounded-xl bg-gradient-to-tr from-[#0067b8] to-sky-400 text-white font-bold text-xs flex items-center justify-center shadow-xs">
                                {{ strtoupper(substr($reply->user->name, 0, 1)) }}
                            </div>
                        @endif

                        <div>
                            <p class="text-xs font-bold text-slate-900 dark:text-white flex items-center gap-2">
                                <span>{{ $reply->user->name }}</span>
                                @if($reply->is_admin_reply)
                                    <span class="text-[10px] font-extrabold px-2 py-0.5 rounded-full bg-purple-100 dark:bg-purple-950 text-purple-700 dark:text-purple-300 border border-purple-200 dark:border-purple-800">
                                        Support Staff
                                    </span>
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

    <!-- Reply Box or Closed Alert -->
    @if($ticket->status === 'closed')
        <div class="p-6 rounded-3xl bg-slate-100 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 text-center space-y-2">
            <i class="fa-solid fa-lock text-slate-400 text-2xl"></i>
            <p class="text-sm font-bold text-slate-800 dark:text-slate-200">This support ticket has been closed.</p>
            <p class="text-xs text-slate-500">If you need further help or have new questions, please open a new support ticket.</p>
            <a href="{{ route('user.tickets.create') }}" class="inline-block mt-2 px-4 py-2 rounded-xl bg-[#0067b8] text-white font-bold text-xs shadow-xs">
                Open New Ticket
            </a>
        </div>
    @else
        <!-- Reply Form -->
        <form action="{{ route('user.tickets.reply', $ticket->id) }}" method="POST" enctype="multipart/form-data" class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs space-y-4">
            @csrf
            <h3 class="text-xs font-black uppercase tracking-wider text-slate-900 dark:text-white flex items-center gap-2">
                <i class="fa-solid fa-reply text-[#0067b8] dark:text-sky-400"></i>
                Post a Reply
            </h3>

            <div>
                <textarea name="message" 
                          rows="4" 
                          required 
                          placeholder="Type your response or follow-up question here..." 
                          class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all"></textarea>
            </div>

            <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div>
                    <input type="file" 
                           name="attachment" 
                           accept="image/*,.pdf,.zip,.doc,.docx"
                           class="text-xs text-slate-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-slate-100 dark:file:bg-slate-800 file:text-slate-700 dark:file:text-slate-300 hover:file:bg-slate-200 file:cursor-pointer">
                    <p class="text-[10px] text-slate-400 mt-0.5">Attach file / screenshot (optional)</p>
                </div>

                <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white text-xs font-bold shadow-md shadow-[#0067b8]/20 active:scale-95 transition-all flex items-center justify-center gap-2 cursor-pointer">
                    <i class="fa-solid fa-paper-plane text-xs"></i>
                    <span>Send Reply</span>
                </button>
            </div>
        </form>
    @endif

</div>
@endsection
