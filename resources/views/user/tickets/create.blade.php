@extends('layouts.user.user')

@section('title', 'Open New Support Ticket | User Portal')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('user.tickets') }}" class="text-slate-500 hover:text-[#0067b8]">Support Tickets</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Open Ticket</span>
@endsection

@section('content')
<div class="max-w-3xl mx-auto space-y-6">

    <!-- Flash Errors -->
    @if($errors->any())
        <div class="p-4 rounded-2xl bg-red-50 dark:bg-red-950/40 border border-red-200 dark:border-red-800/80 text-red-800 dark:text-red-300 shadow-xs">
            <div class="flex items-center gap-3 mb-1">
                <i class="fa-solid fa-circle-exclamation text-red-500 text-lg"></i>
                <p class="text-xs sm:text-sm font-bold">Please correct the following errors:</p>
            </div>
            <ul class="list-disc list-inside text-xs space-y-0.5 ml-6">
                @foreach($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Header -->
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-white tracking-tight flex items-center gap-3">
                <span class="w-10 h-10 rounded-2xl bg-[#0067b8]/10 text-[#0067b8] dark:text-sky-400 flex items-center justify-center text-lg shadow-xs">
                    <i class="fa-solid fa-file-circle-plus"></i>
                </span>
                <span>Open Support Ticket</span>
            </h1>
            <p class="text-xs sm:text-sm text-slate-500 dark:text-slate-400 mt-1">
                Our support team is ready 24/7 to resolve your issues and verify payments.
            </p>
        </div>

        <a href="{{ route('user.tickets') }}" class="px-4 py-2 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-300 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
            <i class="fa-solid fa-arrow-left mr-1.5"></i> Back to Tickets
        </a>
    </div>

    <!-- Form Card -->
    <form action="{{ route('user.tickets.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-8 shadow-xs space-y-5">
            
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                <!-- Department Selection -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Department <span class="text-red-500">*</span>
                    </label>
                    <select name="department" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0067b8] cursor-pointer">
                        <option value="General Support" {{ old('department') === 'General Support' ? 'selected' : '' }}>General Support</option>
                        <option value="Billing & Payments" {{ old('department') === 'Billing & Payments' ? 'selected' : '' }}>Billing & Payments</option>
                        <option value="License & Activation" {{ old('department') === 'License & Activation' ? 'selected' : '' }}>License & Activation</option>
                        <option value="Technical Issue" {{ old('department') === 'Technical Issue' ? 'selected' : '' }}>Technical Issue</option>
                    </select>
                </div>

                <!-- Priority Selection -->
                <div>
                    <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Priority Level <span class="text-red-500">*</span>
                    </label>
                    <select name="priority" required class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs font-bold text-slate-800 dark:text-slate-200 focus:outline-none focus:ring-2 focus:ring-[#0067b8] cursor-pointer">
                        <option value="low" {{ old('priority') === 'low' ? 'selected' : '' }}>Low (General question)</option>
                        <option value="medium" {{ old('priority', 'medium') === 'medium' ? 'selected' : '' }}>Medium (Standard request)</option>
                        <option value="high" {{ old('priority') === 'high' ? 'selected' : '' }}>High (Important service issue)</option>
                        <option value="urgent" {{ old('priority') === 'urgent' ? 'selected' : '' }}>Urgent (Critical outage / payment)</option>
                    </select>
                </div>
            </div>

            <!-- Subject -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                    Subject / Title <span class="text-red-500">*</span>
                </label>
                <input type="text" 
                       name="subject" 
                       value="{{ old('subject') }}" 
                       required 
                       placeholder="Brief summary of your question or issue..." 
                       class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">
            </div>

            <!-- Message Body -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                    Message Details <span class="text-red-500">*</span>
                </label>
                <textarea name="message" 
                          rows="6" 
                          required 
                          placeholder="Please provide full details of your issue, error message, or order number..." 
                          class="w-full px-3.5 py-2.5 rounded-xl bg-slate-50 dark:bg-slate-800/80 border border-slate-200 dark:border-slate-700 text-xs text-slate-900 dark:text-white placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#0067b8] transition-all">{{ old('message') }}</textarea>
            </div>

            <!-- Attachment -->
            <div>
                <label class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                    Attachment Screenshot / Document <span class="text-slate-400 text-[10px] font-normal">(Optional, Max 5MB)</span>
                </label>
                <input type="file" 
                       name="attachment" 
                       accept="image/*,.pdf,.zip,.doc,.docx"
                       class="w-full text-xs text-slate-500 file:mr-3 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-bold file:bg-[#0067b8] file:text-white hover:file:bg-[#005a9e] file:cursor-pointer">
                <p class="text-[11px] text-slate-400 mt-1">Supported formats: JPG, PNG, PDF, ZIP, DOCX</p>
            </div>

        </div>

        <!-- Submit Buttons -->
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('user.tickets') }}" class="px-5 py-2.5 rounded-xl text-xs font-bold text-slate-600 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors">
                Cancel
            </a>
            <button type="submit" class="px-7 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white text-xs sm:text-sm font-bold shadow-md shadow-[#0067b8]/25 active:scale-95 transition-all cursor-pointer flex items-center gap-2">
                <i class="fa-solid fa-paper-plane text-xs"></i>
                <span>Submit Support Ticket</span>
            </button>
        </div>

    </form>

</div>
@endsection
