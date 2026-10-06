@extends('emails.layout')

@php
    $currentStatus = strtolower($status ?? $subscription->status ?? 'active');
    $isSuspended = in_array($currentStatus, ['suspended', 'inactive']);
    $isActive = ($currentStatus === 'active');
@endphp

@section('title', ($isActive ? 'Subscription Activated' : 'Subscription Status Update') . ' - ' . site_setting('site_name', 'Microsoft Office Club'))

@section('content')
    <div style="background: {{ $isActive ? 'linear-gradient(135deg, #059669 0%, #10b981 100%)' : 'linear-gradient(135deg, #e11d48 0%, #f43f5e 100%)' }}; margin: -32px -32px 24px -32px; padding: 24px 32px; text-align: center; color: #ffffff;">
        <h2 style="margin: 0; font-size: 18px; font-weight: 800; color: #ffffff;">
            @if($isActive)
                🎉 Subscription Activated / Active
            @elseif($isSuspended)
                ⚠️ Subscription Suspended
            @else
                Subscription Status: {{ ucfirst($currentStatus) }}
            @endif
        </h2>
        <p style="margin: 4px 0 0 0; font-size: 12px; color: {{ $isActive ? '#d1fae5' : '#ffe4e6' }};">
            {{ $subscription->plan_name }} • Microsoft 365 Cloud Licensing
        </p>
    </div>

    <p style="font-size: 14px; color: #334155;">
        Hello <strong>{{ $subscription->user->name ?? 'Valued Customer' }}</strong>,
    </p>

    @if($isActive)
        <p style="font-size: 14px; color: #334155; line-height: 1.6;">
            Your <strong>{{ $subscription->plan_name }}</strong> subscription has been successfully <strong>Approved & Activated</strong>. You now have full access to genuine Microsoft 365 cloud features.
        </p>
    @elseif($isSuspended)
        <p style="font-size: 14px; color: #334155; line-height: 1.6;">
            We would like to inform you that your Microsoft 365 <strong>{{ $subscription->plan_name }}</strong> subscription has been <strong>Suspended</strong>.
        </p>
    @else
        <p style="font-size: 14px; color: #334155; line-height: 1.6;">
            This is an update regarding the status of your Microsoft 365 <strong>{{ $subscription->plan_name }}</strong> subscription.
        </p>
    @endif

    <div class="card" style="margin: 20px 0; padding: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
        <p style="margin: 0 0 12px 0; font-size: 13px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px;">
            Subscription Summary
        </p>
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Plan Name:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0f172a; text-align: right;">{{ $subscription->plan_name }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">License Account:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0067b8; text-align: right;">{{ $subscription->license_email }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Current Status:</td>
                <td style="padding: 6px 0; text-align: right;">
                    @if($isActive)
                        <span style="background-color: #dcfce7; color: #15803d; font-weight: 800; font-size: 11px; padding: 3px 8px; border-radius: 9999px;">ACTIVE</span>
                    @elseif($isSuspended)
                        <span style="background-color: #fee2e2; color: #dc2626; font-weight: 800; font-size: 11px; padding: 3px 8px; border-radius: 9999px;">SUSPENDED</span>
                    @else
                        <span style="background-color: #fef3c7; color: #b45309; font-weight: 800; font-size: 11px; padding: 3px 8px; border-radius: 9999px;">{{ strtoupper($currentStatus) }}</span>
                    @endif
                </td>
            </tr>
            @if($subscription->expires_at)
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Expiry Date:</td>
                <td style="padding: 6px 0; font-weight: 600; color: #0f172a; text-align: right;">{{ $subscription->expires_at->format('M d, Y') }}</td>
            </tr>
            @endif
            @if(!empty($notes) || !empty($subscription->admin_notes))
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600; vertical-align: top;">Notes:</td>
                <td style="padding: 6px 0; font-weight: 500; color: #475569; text-align: right;">{{ $notes ?: $subscription->admin_notes }}</td>
            </tr>
            @endif
        </table>
    </div>

    @if($isActive)
        <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-left: 4px solid #16a34a; border-radius: 8px; padding: 14px 16px; margin: 20px 0; font-size: 13px; color: #166534; line-height: 1.6;">
            <strong>Setup Guide:</strong> Sign in at <a href="https://www.office.com" target="_blank" style="color: #0067b8; font-weight: bold;">www.office.com</a> using your email <strong>{{ $subscription->license_email }}</strong> to download Office applications and access 1 TB OneDrive cloud storage.
        </div>
    @elseif($isSuspended)
        <div style="background-color: #fff1f2; border: 1px solid #fecdd3; border-left: 4px solid #e11d48; border-radius: 8px; padding: 14px 16px; margin: 20px 0; font-size: 13px; color: #9f1239; line-height: 1.6;">
            <strong>Subscription Suspended Notice:</strong> If you believe this suspension was made in error or if you need to renew/reactivate your license, please get in touch with our customer care immediately.
        </div>
    @endif

    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ route('user.subscriptions') }}" class="btn" style="background-color: #0067b8; color: #ffffff; padding: 12px 28px; border-radius: 10px; font-weight: bold; text-decoration: none; display: inline-block;">
            View Subscriptions in Dashboard &rarr;
        </a>
    </div>

    <p style="margin-top: 24px; font-size: 12px; color: #94a3b8; text-align: center;">
        Need help? Reply directly to this email or contact support at {{ site_setting('contact_email', 'support@microsoftoffice.club') }}.
    </p>
@endsection
