@extends('layouts.admin.admin')

@section('title', 'Inquiry from ' . $contactMessage->name . ' | Microsoft Office Club Bangladesh')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('admin.contact-messages.index') }}" class="hover:text-[#0067b8] dark:hover:text-sky-400 transition-colors">
        Contact Inquiries
    </a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">
        {{ $contactMessage->name }}
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

    <!-- Top Bar -->
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
        <div>
            <div class="flex items-center gap-2.5">
                <h2 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-white tracking-tight">
                    Inquiry Details
                </h2>
                <span class="text-[10px] font-bold px-2.5 py-0.5 rounded-full {{ $contactMessage->is_read ? 'bg-emerald-100 text-emerald-700 dark:bg-emerald-950/80 dark:text-emerald-400' : 'bg-rose-100 text-rose-700 dark:bg-rose-950/80 dark:text-rose-400' }}">
                    {{ $contactMessage->is_read ? 'Read' : 'Unread' }}
                </span>
            </div>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-0.5">
                Received {{ $contactMessage->created_at->format('l, F j, Y \a\t h:i A') }} ({{ $contactMessage->created_at->diffForHumans() }})
            </p>
        </div>
        <div class="flex items-center gap-2">
            <form action="{{ route('admin.contact-messages.toggle-read', $contactMessage) }}" method="POST">
                @csrf
                <button type="submit" class="text-xs font-bold text-slate-700 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex items-center gap-1.5 cursor-pointer">
                    <i class="fa-regular {{ $contactMessage->is_read ? 'fa-envelope' : 'fa-envelope-open' }} text-xs text-[#0067b8]"></i>
                    <span>{{ $contactMessage->is_read ? 'Mark Unread' : 'Mark Read' }}</span>
                </button>
            </form>
            <a href="{{ route('admin.contact-messages.index') }}" class="text-xs font-bold text-slate-600 dark:text-slate-300 hover:text-slate-900 dark:hover:text-white px-3.5 py-2 rounded-xl border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex items-center gap-1.5">
                <i class="fa-solid fa-arrow-left text-xs"></i>
                <span>Back to Inbox</span>
            </a>
        </div>
    </div>

    <!-- Main Content Grid -->
    <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
        
        <!-- Left Column: Message Content -->
        <div class="lg:col-span-8 space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-xs space-y-6">
                
                <!-- Sender Header Card -->
                <div class="flex items-start justify-between gap-4 pb-6 border-b border-slate-100 dark:border-slate-800">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#0067b8] text-white font-bold flex items-center justify-center text-base shadow-sm">
                            {{ strtoupper(substr($contactMessage->name, 0, 2)) }}
                        </div>
                        <div>
                            <h3 class="text-lg font-bold text-slate-900 dark:text-white">
                                {{ $contactMessage->name }}
                            </h3>
                            <p class="text-xs text-slate-500 dark:text-slate-400">
                                {{ $contactMessage->email }}
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Message Body -->
                <div class="space-y-2">
                    <label class="block text-[11px] font-bold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                        Inquiry Message
                    </label>
                    <div class="bg-slate-50/80 dark:bg-slate-800/60 rounded-2xl p-5 border border-slate-100 dark:border-slate-700/60 text-slate-800 dark:text-slate-200 text-sm leading-relaxed whitespace-pre-line font-normal">
                        {{ $contactMessage->message }}
                    </div>
                </div>

                <!-- Fast Reply Actions -->
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex flex-wrap items-center gap-3">
                    <a href="mailto:{{ $contactMessage->email }}?subject=Regarding%20Your%20Microsoft%20365%20Inquiry" class="bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold px-5 py-2.5 rounded-xl text-xs sm:text-sm flex items-center gap-2 shadow-md shadow-[#0067b8]/20 transition-all">
                        <i class="fa-solid fa-reply text-xs"></i>
                        <span>Reply via Email</span>
                    </a>

                    @if($contactMessage->phone)
                        @php
                            $cleanPhone = preg_replace('/[^0-9]/', '', $contactMessage->phone);
                            if (str_starts_with($cleanPhone, '01')) {
                                $cleanPhone = '88' . $cleanPhone;
                            }
                        @endphp
                        <a href="https://wa.me/{{ $cleanPhone }}?text=Hello%20{{ urlencode($contactMessage->name) }}%2C%20thank%20you%20for%20contacting%20Microsoft%20365%20Reseller%20BD." target="_blank" class="bg-emerald-600 hover:bg-emerald-700 text-white font-bold px-5 py-2.5 rounded-xl text-xs sm:text-sm flex items-center gap-2 shadow-md shadow-emerald-600/20 transition-all">
                            <i class="fa-brands fa-whatsapp text-sm"></i>
                            <span>Chat on WhatsApp</span>
                        </a>

                        <a href="tel:{{ $contactMessage->phone }}" class="border border-slate-200 dark:border-slate-700 hover:bg-slate-100 dark:hover:bg-slate-800 text-slate-700 dark:text-slate-300 font-bold px-4 py-2.5 rounded-xl text-xs sm:text-sm flex items-center gap-2 transition-all">
                            <i class="fa-solid fa-phone text-xs"></i>
                            <span>Call {{ $contactMessage->phone }}</span>
                        </a>
                    @endif

                    <button type="button" onclick="openDeleteModal('{{ route('admin.contact-messages.destroy', $contactMessage) }}', '{{ addslashes($contactMessage->name) }}')" class="ml-auto text-rose-600 hover:text-rose-700 hover:bg-rose-50 dark:hover:bg-rose-950/50 px-3.5 py-2.5 rounded-xl text-xs font-bold transition-colors cursor-pointer">
                        <i class="fa-regular fa-trash-can mr-1"></i> Delete Message
                    </button>
                </div>

            </div>
        </div>

        <!-- Right Column: Meta & Client Details -->
        <div class="lg:col-span-4 space-y-6">
            <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 shadow-xs space-y-4">
                <h4 class="text-xs font-extrabold uppercase tracking-wider text-slate-400 dark:text-slate-500">
                    Sender Information
                </h4>

                <div class="space-y-3 text-xs">
                    <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-slate-500 dark:text-slate-400">Full Name</span>
                        <span class="font-bold text-slate-900 dark:text-white">{{ $contactMessage->name }}</span>
                    </div>

                    <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-slate-500 dark:text-slate-400">Email</span>
                        <a href="mailto:{{ $contactMessage->email }}" class="font-bold text-[#0067b8] dark:text-sky-400 hover:underline">{{ $contactMessage->email }}</a>
                    </div>

                    <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-slate-500 dark:text-slate-400">Phone / WhatsApp</span>
                        <span class="font-bold text-slate-900 dark:text-white">{{ $contactMessage->phone ?: 'Not provided' }}</span>
                    </div>

                    <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                        <span class="text-slate-500 dark:text-slate-400">Status</span>
                        <span class="font-bold {{ $contactMessage->is_read ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $contactMessage->is_read ? 'Read' : 'Unread' }}
                        </span>
                    </div>

                    @if($contactMessage->read_at)
                        <div class="flex items-center justify-between pb-2 border-b border-slate-100 dark:border-slate-800">
                            <span class="text-slate-500 dark:text-slate-400">First Read</span>
                            <span class="text-slate-700 dark:text-slate-300">{{ $contactMessage->read_at->format('M d, Y h:i A') }}</span>
                        </div>
                    @endif

                    @if($contactMessage->ip_address)
                        <div class="flex items-center justify-between pt-1">
                            <span class="text-slate-500 dark:text-slate-400">IP Address</span>
                            <span class="font-mono text-[11px] text-slate-600 dark:text-slate-400">{{ $contactMessage->ip_address }}</span>
                        </div>
                    @endif
                </div>

            </div>
        </div>

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
