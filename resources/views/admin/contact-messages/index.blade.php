@extends('layouts.admin.admin')

@section('title', 'Contact Messages & Inquiries | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        Contact Inquiries
    </span>
@endsection

@section('content')

    <!-- Success Alert -->
    @if(session('success'))
        <div class="bg-emerald-50 dark:bg-emerald-950/60 border border-emerald-200 dark:border-emerald-800 text-emerald-800 dark:text-emerald-300 px-5 py-4 rounded-2xl flex items-center gap-3 shadow-xs">
            <i class="fa-solid fa-circle-check text-lg text-emerald-600 dark:text-emerald-400 shrink-0"></i>
            <p class="text-xs sm:text-sm font-semibold">{{ session('success') }}</p>
        </div>
    @endif

    <!-- Page Title & Action Buttons -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                    Contact Messages & Inquiries
                </h2>
                @if($stats['unread'] > 0)
                    <span class="bg-rose-500 text-white text-[11px] font-black px-2.5 py-0.5 rounded-full shadow-xs animate-pulse">
                        {{ $stats['unread'] }} New
                    </span>
                @endif
            </div>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Messages and business inquiries submitted from the storefront Contact Us form.
            </p>
        </div>
        <div class="flex items-center gap-3">
            @if($stats['unread'] > 0)
                <form action="{{ route('admin.contact-messages.mark-all-read') }}" method="POST">
                    @csrf
                    <button type="submit" class="bg-white dark:bg-slate-800 hover:bg-slate-50 dark:hover:bg-slate-700 text-slate-700 dark:text-slate-200 border border-slate-200 dark:border-slate-700 font-bold px-4 py-2.5 rounded-xl text-xs flex items-center gap-2 shadow-xs transition-all cursor-pointer">
                        <i class="fa-solid fa-envelope-open-text text-xs text-[#0067b8] dark:text-sky-400"></i>
                        <span>Mark All as Read</span>
                    </button>
                </form>
            @endif
            <a href="{{ route('home') }}#contact-support" target="_blank" class="hidden sm:flex items-center gap-1.5 text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-[#0067b8] dark:hover:text-sky-400 px-3.5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                <i class="fa-solid fa-arrow-up-right-from-square text-xs text-[#0067b8] dark:text-sky-400"></i>
                <span>View Form on Site</span>
            </a>
        </div>
    </div>

    <!-- Stats Bar -->
    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Total Messages</p>
                <p class="text-xl font-black text-slate-900 dark:text-white mt-0.5">{{ $stats['total'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-blue-50 dark:bg-blue-950/60 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-base">
                <i class="fa-solid fa-inbox"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Unread Inquiries</p>
                <p class="text-xl font-black text-rose-600 dark:text-rose-400 mt-0.5">{{ $stats['unread'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center text-base">
                <i class="fa-solid fa-envelope"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Read Messages</p>
                <p class="text-xl font-black text-emerald-600 dark:text-emerald-400 mt-0.5">{{ $stats['read'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-emerald-50 dark:bg-emerald-950/60 text-emerald-600 dark:text-emerald-400 flex items-center justify-center text-base">
                <i class="fa-solid fa-envelope-circle-check"></i>
            </div>
        </div>

        <div class="bg-white dark:bg-slate-900 p-4 rounded-2xl border border-slate-200/90 dark:border-slate-800 shadow-xs flex items-center justify-between">
            <div>
                <p class="text-[11px] font-bold text-slate-400 uppercase tracking-wider">Today's Inquiries</p>
                <p class="text-xl font-black text-indigo-600 dark:text-indigo-400 mt-0.5">{{ $stats['today'] }}</p>
            </div>
            <div class="w-10 h-10 rounded-xl bg-indigo-50 dark:bg-indigo-950/60 text-indigo-600 dark:text-indigo-400 flex items-center justify-center text-base">
                <i class="fa-solid fa-calendar-day"></i>
            </div>
        </div>
    </div>

    <!-- Filters & Search Bar -->
    <div class="bg-white dark:bg-slate-900 rounded-2xl border border-slate-200/90 dark:border-slate-800 p-4 shadow-xs flex flex-col sm:flex-row items-center justify-between gap-4">
        
        <!-- Status Filter Tabs -->
        <div class="flex items-center gap-1 bg-slate-100 dark:bg-slate-800 p-1 rounded-xl w-full sm:w-auto">
            <a href="{{ route('admin.contact-messages.index') }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all text-center flex-1 sm:flex-none {{ !request('status') ? 'bg-white dark:bg-slate-700 text-slate-900 dark:text-white shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900' }}">
                All ({{ $stats['total'] }})
            </a>
            <a href="{{ route('admin.contact-messages.index', ['status' => 'unread']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all text-center flex-1 sm:flex-none {{ request('status') === 'unread' ? 'bg-white dark:bg-slate-700 text-rose-600 dark:text-rose-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900' }}">
                Unread ({{ $stats['unread'] }})
            </a>
            <a href="{{ route('admin.contact-messages.index', ['status' => 'read']) }}" class="px-3.5 py-1.5 rounded-lg text-xs font-bold transition-all text-center flex-1 sm:flex-none {{ request('status') === 'read' ? 'bg-white dark:bg-slate-700 text-emerald-600 dark:text-emerald-400 shadow-xs' : 'text-slate-600 dark:text-slate-400 hover:text-slate-900' }}">
                Read ({{ $stats['read'] }})
            </a>
        </div>

        <!-- Search Form -->
        <form action="{{ route('admin.contact-messages.index') }}" method="GET" class="w-full sm:w-72 flex items-center relative">
            @if(request('status'))
                <input type="hidden" name="status" value="{{ request('status') }}">
            @endif
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search sender, email, phone..." class="w-full pl-9 pr-4 py-2 rounded-xl border border-slate-200 dark:border-slate-700 bg-slate-50 dark:bg-slate-800 text-xs text-slate-900 dark:text-white focus:outline-hidden focus:ring-2 focus:ring-[#0067b8]/20 focus:border-[#0067b8] transition-all">
            <i class="fa-solid fa-magnifying-glass absolute left-3 text-slate-400 text-xs"></i>
            @if(request('search'))
                <a href="{{ route('admin.contact-messages.index', request()->except('search')) }}" class="absolute right-3 text-slate-400 hover:text-slate-600 text-xs">
                    <i class="fa-solid fa-xmark"></i>
                </a>
            @endif
        </form>
    </div>

    <!-- Messages Table Card -->
    <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 overflow-hidden shadow-xs">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200/80 dark:border-slate-800 bg-slate-50/50 dark:bg-slate-800/30 text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        <th class="py-3.5 px-6">Sender</th>
                        <th class="py-3.5 px-6">Contact Info</th>
                        <th class="py-3.5 px-6">Message Preview</th>
                        <th class="py-3.5 px-6">Received</th>
                        <th class="py-3.5 px-6">Status</th>
                        <th class="py-3.5 px-6 text-right">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 dark:divide-slate-800/60 text-xs">
                    @forelse($messages as $msg)
                        <tr class="hover:bg-slate-50/70 dark:hover:bg-slate-800/40 transition-colors {{ !$msg->is_read ? 'bg-sky-50/20 dark:bg-sky-950/10 font-medium' : '' }}">
                            
                            <!-- Sender Name -->
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-3">
                                    <div class="w-9 h-9 rounded-xl {{ !$msg->is_read ? 'bg-[#0067b8] text-white font-bold' : 'bg-slate-100 dark:bg-slate-800 text-slate-600 dark:text-slate-300' }} flex items-center justify-center text-xs shrink-0 shadow-2xs">
                                        {{ strtoupper(substr($msg->name, 0, 2)) }}
                                    </div>
                                    <div>
                                        <a href="{{ route('admin.contact-messages.show', $msg) }}" class="font-bold text-slate-900 dark:text-white hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">
                                            {{ $msg->name }}
                                        </a>
                                        @if(!$msg->is_read)
                                            <span class="inline-block w-2 h-2 rounded-full bg-rose-500 ml-1" title="Unread"></span>
                                        @endif
                                    </div>
                                </div>
                            </td>

                            <!-- Contact Info -->
                            <td class="py-4 px-6">
                                <div class="space-y-0.5">
                                    <div class="flex items-center gap-1.5 text-slate-700 dark:text-slate-300">
                                        <i class="fa-regular fa-envelope text-[11px] text-slate-400"></i>
                                        <a href="mailto:{{ $msg->email }}" class="hover:text-[#0067b8] dark:hover:text-sky-400 underline decoration-slate-300">
                                            {{ $msg->email }}
                                        </a>
                                    </div>
                                    @if($msg->phone)
                                        <div class="flex items-center gap-1.5 text-slate-600 dark:text-slate-400">
                                            <i class="fa-brands fa-whatsapp text-[11px] text-emerald-500"></i>
                                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $msg->phone) }}" target="_blank" class="hover:text-emerald-600">
                                                {{ $msg->phone }}
                                            </a>
                                        </div>
                                    @endif
                                </div>
                            </td>

                            <!-- Message Preview -->
                            <td class="py-4 px-6">
                                <a href="{{ route('admin.contact-messages.show', $msg) }}" class="text-slate-600 dark:text-slate-300 line-clamp-2 hover:text-slate-900 dark:hover:text-white transition-colors max-w-sm block">
                                    {{ $msg->message }}
                                </a>
                            </td>

                            <!-- Date Received -->
                            <td class="py-4 px-6 whitespace-nowrap text-slate-500 dark:text-slate-400">
                                <div title="{{ $msg->created_at->format('M d, Y h:i A') }}">
                                    {{ $msg->created_at->diffForHumans() }}
                                </div>
                            </td>

                            <!-- Status Badge -->
                            <td class="py-4 px-6 whitespace-nowrap">
                                <form action="{{ route('admin.contact-messages.toggle-read', $msg) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="text-[10px] font-bold px-2.5 py-1 rounded-full cursor-pointer transition-all {{ $msg->is_read ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-400 hover:bg-emerald-200' : 'bg-rose-100 text-rose-700 dark:bg-rose-950/80 dark:text-rose-400 hover:bg-rose-200' }}" title="Click to Toggle Read Status">
                                        <span class="w-1.5 h-1.5 rounded-full inline-block mr-1 {{ $msg->is_read ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                        {{ $msg->is_read ? 'Read' : 'Unread' }}
                                    </button>
                                </form>
                            </td>

                            <!-- Actions -->
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="flex items-center justify-end gap-1.5">
                                    <a href="{{ route('admin.contact-messages.show', $msg) }}" class="p-2 rounded-xl text-slate-500 hover:text-[#0067b8] hover:bg-blue-50 dark:hover:bg-blue-950/50 transition-colors" title="View Full Message">
                                        <i class="fa-regular fa-eye text-sm"></i>
                                    </a>

                                    <button type="button" onclick="openDeleteModal('{{ route('admin.contact-messages.destroy', $msg) }}', '{{ addslashes($msg->name) }}')" class="p-2 rounded-xl text-slate-400 hover:text-rose-600 hover:bg-rose-50 dark:hover:bg-rose-950/50 transition-colors cursor-pointer" title="Delete Message">
                                        <i class="fa-regular fa-trash-can text-sm"></i>
                                    </button>
                                </div>
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 dark:text-slate-500">
                                <div class="w-12 h-12 rounded-2xl bg-slate-100 dark:bg-slate-800 text-slate-400 flex items-center justify-center text-xl mx-auto mb-3">
                                    <i class="fa-regular fa-envelope-open"></i>
                                </div>
                                <p class="text-sm font-bold text-slate-700 dark:text-slate-300">No contact messages found</p>
                                <p class="text-xs mt-1">Inquiries sent from the storefront will appear here.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($messages->hasPages())
            <div class="px-6 py-4 border-t border-slate-100 dark:border-slate-800">
                {{ $messages->links() }}
            </div>
        @endif
    </div>

    <!-- Custom Delete Confirmation Modal Popup -->
    <div id="deleteModal" class="fixed inset-0 z-50 hidden bg-slate-900/60 backdrop-blur-xs flex items-center justify-center p-4">
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200 dark:border-slate-800 p-6 max-w-md w-full shadow-2xl space-y-4 animate-in fade-in zoom-in-95 duration-150">
            <div class="w-12 h-12 rounded-2xl bg-rose-50 dark:bg-rose-950/60 text-rose-600 dark:text-rose-400 flex items-center justify-center text-xl mx-auto">
                <i class="fa-solid fa-triangle-exclamation"></i>
            </div>
            
            <div class="text-center space-y-2">
                <h3 class="text-lg font-bold text-slate-900 dark:text-white">Delete Message</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400 leading-relaxed">
                    Are you sure you want to delete the message from <span id="deleteItemTitle" class="font-bold text-slate-800 dark:text-slate-200"></span>? This action cannot be undone.
                </p>
            </div>

            <form id="deleteForm" method="POST" class="flex gap-3 pt-2">
                @csrf
                @method('DELETE')
                <button type="button" onclick="closeDeleteModal()" class="flex-1 py-2.5 px-4 rounded-xl border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-700 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors cursor-pointer">
                    Cancel
                </button>
                <button type="submit" class="flex-1 py-2.5 px-4 rounded-xl bg-rose-600 hover:bg-rose-700 text-white text-xs font-bold shadow-md shadow-rose-600/20 transition-colors cursor-pointer">
                    Yes, Delete
                </button>
            </form>
        </div>
    </div>

    <script>
        function openDeleteModal(actionUrl, itemName) {
            document.getElementById('deleteForm').action = actionUrl;
            document.getElementById('deleteItemTitle').textContent = `"${itemName}"`;
            document.getElementById('deleteModal').classList.remove('hidden');
        }

        function closeDeleteModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }

        document.getElementById('deleteModal')?.addEventListener('click', function(e) {
            if (e.target === this) {
                closeDeleteModal();
            }
        });
    </script>

@endsection
