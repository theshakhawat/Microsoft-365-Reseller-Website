@extends('emails.layout')

@section('title', 'Order Approved & Subscription Activated - #' . $order->order_number . ' | ' . site_setting('site_name', 'Microsoft Office Club'))

@section('content')
    <div style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); margin: -32px -32px 24px -32px; padding: 24px 32px; text-align: center; color: #ffffff;">
        <h2 style="margin: 0; font-size: 18px; font-weight: 800; color: #ffffff;">
            🎉 Subscription Activated & Approved!
        </h2>
        <p style="margin: 4px 0 0 0; font-size: 12px; color: #d1fae5;">
            Order #{{ $order->order_number }} • Microsoft 365 Cloud License
        </p>
    </div>

    <p style="font-size: 14px; color: #334155;">
        Hello <strong>{{ $order->recipient_name ?: ($order->user->name ?? 'Valued Customer') }}</strong>,
    </p>

    <p style="font-size: 14px; color: #334155; line-height: 1.6;">
        Great news! Your payment for Order <strong>#{{ $order->order_number }}</strong> has been verified and your <strong>{{ $order->plan_name }}</strong> subscription has been successfully <strong>Activated</strong>.
    </p>

    <div class="card" style="margin: 20px 0; padding: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
        <p style="margin: 0 0 12px 0; font-size: 13px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px;">
            Subscription License Details
        </p>
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Plan Name:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0f172a; text-align: right;">{{ $order->plan_name }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">License Account:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0067b8; text-align: right;">{{ $order->recipient_email }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Status:</td>
                <td style="padding: 6px 0; text-align: right;">
                    <span style="background-color: #dcfce7; color: #15803d; font-weight: 800; font-size: 11px; padding: 3px 8px; border-radius: 9999px;">ACTIVE</span>
                </td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Cloud Storage:</td>
                <td style="padding: 6px 0; font-weight: 600; color: #0f172a; text-align: right;">1 TB OneDrive Secure Cloud</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Paid Amount:</td>
                <td style="padding: 6px 0; font-weight: 800; color: #059669; text-align: right;">৳{{ number_format($order->payable_amount, 2) }} BDT</td>
            </tr>
        </table>
    </div>

    <div style="background-color: #f0fdf4; border: 1px solid #bbf7d0; border-left: 4px solid #16a34a; border-radius: 8px; padding: 14px 16px; margin: 20px 0; font-size: 13px; color: #166534; line-height: 1.6;">
        <strong>How to Start Using Microsoft 365:</strong>
        <ol style="margin: 8px 0 0 0; padding-left: 20px;">
            <li>Visit <a href="https://www.office.com" target="_blank" style="color: #0067b8; font-weight: bold;">www.office.com</a> or <a href="https://portal.office.com" target="_blank" style="color: #0067b8; font-weight: bold;">portal.office.com</a></li>
            <li>Sign in with your registered Microsoft email: <strong>{{ $order->recipient_email }}</strong></li>
            <li>Download & install Word, Excel, PowerPoint, Outlook, and sync 1 TB OneDrive!</li>
        </ol>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ route('user.subscriptions') }}" class="btn" style="background-color: #0067b8; color: #ffffff; padding: 12px 28px; border-radius: 10px; font-weight: bold; text-decoration: none; display: inline-block;">
            Open Subscriptions Dashboard &rarr;
        </a>
    </div>

    <p style="margin-top: 24px; font-size: 12px; color: #94a3b8; text-align: center;">
        Need technical assistance or setup help? Reply to this email or chat with our 24/7 support.
    </p>
@endsection
