@extends('layouts.admin.admin')

@section('title', 'Manual Subscription Provisioning | Microsoft Office Club Admin')

@section('breadcrumb')
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <a href="{{ route('admin.subscriptions.index') }}" class="hover:text-[#0067b8] transition-colors">Subscriptions</a>
    <i class="fa-solid fa-chevron-right text-[10px] text-slate-300 dark:text-slate-600"></i>
    <span class="font-bold text-slate-900 dark:text-white">Create / Assign</span>
@endsection

@section('content')

    @if($errors->any())
    <div class="mb-6 p-4 rounded-2xl bg-red-50 dark:bg-red-950/60 border border-red-200 dark:border-red-800 text-red-800 dark:text-red-300 text-xs sm:text-sm space-y-1">
        <div class="flex items-center gap-2 font-bold mb-1">
            <i class="fa-solid fa-circle-exclamation text-base text-red-600"></i>
            <span>Please correct the errors below:</span>
        </div>
        <ul class="list-disc list-inside space-y-0.5 text-xs">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div class="max-w-3xl">
        <div class="bg-white dark:bg-slate-900 rounded-3xl border border-slate-200/90 dark:border-slate-800 p-6 sm:p-9 shadow-xs">
            
            <div class="pb-6 border-b border-slate-100 dark:border-slate-800 flex items-center justify-between">
                <div>
                    <h1 class="text-xl font-black text-slate-900 dark:text-white">Manually Assign / Create License</h1>
                    <p class="text-xs text-slate-400 mt-0.5">Provision an active Microsoft 365 cloud subscription directly to a customer.</p>
                </div>
                <a href="{{ route('admin.subscriptions.index') }}" class="text-xs font-bold text-slate-500 hover:text-slate-800 dark:hover:text-slate-200">
                    &larr; Back
                </a>
            </div>

            <form action="{{ route('admin.subscriptions.store') }}" method="POST" class="mt-6 space-y-5">
                @csrf

                <!-- Customer Selection -->
                <div>
                    <label for="user_id" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Select Customer Account <span class="text-red-500">*</span>
                    </label>
                    <select name="user_id" id="user_id" required class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                        <option value="">-- Choose User --</option>
                        @foreach($users as $cust)
                            <option value="{{ $cust->id }}" {{ old('user_id') == $cust->id ? 'selected' : '' }}>
                                {{ $cust->name }} ({{ $cust->email }})
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Plan Selection & Name -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="pricing_plan_id" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Preset Plan Template
                        </label>
                        <select name="pricing_plan_id" id="pricing_plan_id" onchange="fillPlanDetails(this)" class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                            <option value="">-- Custom Plan --</option>
                            @foreach($plans as $p)
                                <option value="{{ $p->id }}" data-name="{{ $p->name }}" {{ old('pricing_plan_id') == $p->id ? 'selected' : '' }}>
                                    {{ $p->name }} ({{ $p->price_bdt }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div>
                        <label for="plan_name" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Plan Display Name <span class="text-red-500">*</span>
                        </label>
                        <input type="text" name="plan_name" id="plan_name" value="{{ old('plan_name', 'Microsoft 365 Personal') }}" required class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                    </div>
                </div>

                <!-- License Account Email -->
                <div>
                    <label for="license_email" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Licensed Microsoft Account Email <span class="text-red-500">*</span>
                    </label>
                    <input type="email" name="license_email" id="license_email" value="{{ old('license_email') }}" placeholder="e.g. user@outlook.com or customer's personal email" required class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                </div>

                <!-- Start Date & Expiry Date -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="starts_at" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Activation / Start Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="starts_at" id="starts_at" value="{{ old('starts_at', date('Y-m-d')) }}" required class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                    </div>

                    <div>
                        <label for="expires_at" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Expiration Date <span class="text-red-500">*</span>
                        </label>
                        <input type="date" name="expires_at" id="expires_at" value="{{ old('expires_at', date('Y-m-d', strtotime('+1 year'))) }}" required class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                    </div>
                </div>

                <!-- Status & Cloud Storage -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                    <div>
                        <label for="status" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Initial Status <span class="text-red-500">*</span>
                        </label>
                        <select name="status" id="status" required class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                            <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active & Verified</option>
                            <option value="suspended" {{ old('status') === 'suspended' ? 'selected' : '' }}>Suspended</option>
                            <option value="inactive" {{ old('status') === 'inactive' ? 'selected' : '' }}>Inactive</option>
                        </select>
                    </div>

                    <div>
                        <label for="cloud_storage" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                            Cloud Storage Capacity
                        </label>
                        <input type="text" name="cloud_storage" id="cloud_storage" value="{{ old('cloud_storage', '1 TB OneDrive Cloud Storage') }}" class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]">
                    </div>
                </div>

                <!-- Admin Notes -->
                <div>
                    <label for="admin_notes" class="block text-xs font-bold text-slate-700 dark:text-slate-300 mb-1.5">
                        Internal Admin Notes (Optional)
                    </label>
                    <textarea name="admin_notes" id="admin_notes" rows="2" placeholder="e.g. Bulk order for corporate client, offline bank payment..." class="w-full px-3.5 py-2.5 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl text-xs font-medium text-slate-900 dark:text-white focus:ring-2 focus:ring-[#0067b8]"></textarea>
                </div>

                <!-- Submit Action -->
                <div class="pt-4 border-t border-slate-100 dark:border-slate-800 flex justify-end gap-3">
                    <a href="{{ route('admin.subscriptions.index') }}" class="px-5 py-2.5 rounded-xl border border-slate-200 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-bold text-xs hover:bg-slate-50 dark:hover:bg-slate-800">
                        Cancel
                    </a>
                    <button type="submit" class="px-6 py-2.5 rounded-xl bg-[#0067b8] hover:bg-[#005a9e] text-white font-bold text-xs shadow-md active:scale-95 transition-all">
                        Provision & Activate License
                    </button>
                </div>

            </form>

        </div>
    </div>

@push('scripts')
<script>
    function fillPlanDetails(selectEl) {
        const selectedOption = selectEl.options[selectEl.selectedIndex];
        const planName = selectedOption.getAttribute('data-name');
        if (planName) {
            document.getElementById('plan_name').value = planName;
        }
    }
</script>
@endpush

@endsection
