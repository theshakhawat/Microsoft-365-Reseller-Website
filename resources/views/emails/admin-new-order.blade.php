@extends('emails.layout')

@section('title', 'New Paid Order Alert - #' . $order->order_number . ' | ' . site_setting('site_name', 'Microsoft Office Club'))

@section('content')
    <div style="background: linear-gradient(135deg, #0b192c 0%, #0067b8 100%); margin: -32px -32px 24px -32px; padding: 24px 32px; text-align: center; color: #ffffff;">
        <h2 style="margin: 0; font-size: 18px; font-weight: 800; color: #ffffff;">
            🚨 New Paid Order Awaiting Activation!
        </h2>
        <p style="margin: 4px 0 0 0; font-size: 12px; color: #bae0fd;">
            Order #{{ $order->order_number }} • Ready for Admin Approval
        </p>
    </div>

    <p style="font-size: 14px; color: #334155;">
        Hello Admin,
    </p>

    <p style="font-size: 14px; color: #334155; line-height: 1.6;">
        A customer has placed and paid for an order on <strong>{{ site_setting('site_name', 'Microsoft Office Club') }}</strong>. Please review the payment and activate the customer's Microsoft 365 cloud subscription license.
    </p>

    <div class="card" style="margin: 20px 0; padding: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
        <p style="margin: 0 0 12px 0; font-size: 13px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px;">
            Order & Customer Overview
        </p>
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Order ID:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0067b8; text-align: right; font-family: monospace;">#{{ $order->order_number }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Customer Name:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0f172a; text-align: right;">{{ $order->recipient_name ?: ($order->user->name ?? 'N/A') }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Customer Email:</td>
                <td style="padding: 6px 0; font-weight: 600; color: #0067b8; text-align: right;">{{ $order->recipient_email }}</td>
            </tr>
            @if($order->recipient_phone)
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Customer Phone:</td>
                <td style="padding: 6px 0; font-weight: 600; color: #0f172a; text-align: right;">{{ $order->recipient_phone }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Ordered Plan:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0f172a; text-align: right;">{{ $order->plan_name }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Amount Paid:</td>
                <td style="padding: 6px 0; font-weight: 800; color: #059669; text-align: right; font-size: 15px;">৳{{ number_format($order->payable_amount, 2) }} BDT</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Payment Gateway:</td>
                <td style="padding: 6px 0; font-weight: 600; color: #475569; text-align: right;">{{ ucfirst($order->payment_method_slug ?: 'Online Payment') }}</td>
            </tr>
            @if($order->gateway_txn_id)
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Transaction ID:</td>
                <td style="padding: 6px 0; font-weight: 600; color: #0f172a; text-align: right; font-family: monospace;">{{ $order->gateway_txn_id }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Paid At:</td>
                <td style="padding: 6px 0; font-weight: 600; color: #475569; text-align: right;">{{ ($order->paid_at ?? now())->format('M d, Y - h:i A') }}</td>
            </tr>
        </table>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ route('admin.orders.show', $order->id) }}" class="btn" style="background-color: #0067b8; color: #ffffff; padding: 12px 30px; border-radius: 10px; font-weight: bold; text-decoration: none; display: inline-block;">
            Open Order & Activate Subscription &rarr;
        </a>
    </div>

    <p style="margin-top: 24px; font-size: 12px; color: #94a3b8; text-align: center;">
        This is an automated notification from your {{ site_setting('site_name', 'Microsoft Office Club') }} Admin Portal.
    </p>
@endsection
