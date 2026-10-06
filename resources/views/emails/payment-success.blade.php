@extends('emails.layout')

@section('title', 'Payment Received & Verified - #' . $order->order_number . ' | ' . site_setting('site_name', 'Microsoft Office Club'))

@section('content')
    <div style="background: linear-gradient(135deg, #059669 0%, #10b981 100%); margin: -32px -32px 24px -32px; padding: 24px 32px; text-align: center; color: #ffffff;">
        <h2 style="margin: 0; font-size: 18px; font-weight: 800; color: #ffffff;">
            ✅ Payment Successful & Verified!
        </h2>
        <p style="margin: 4px 0 0 0; font-size: 12px; color: #d1fae5;">
            Official Receipt for Order #{{ $order->order_number }}
        </p>
    </div>

    <p style="font-size: 14px; color: #334155;">
        Hello <strong>{{ $order->recipient_name ?: ($order->user->name ?? 'Valued Customer') }}</strong>,
    </p>

    <p style="font-size: 14px; color: #334155; line-height: 1.6;">
        We have successfully received and confirmed your payment of <strong>৳{{ number_format($order->payable_amount, 2) }} BDT</strong>. Your order is now ready for license provisioning.
    </p>

    <div class="card" style="margin: 20px 0; padding: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
        <p style="margin: 0 0 12px 0; font-size: 13px; font-weight: 800; color: #0f172a; text-transform: uppercase; letter-spacing: 0.5px;">
            Payment Receipt
        </p>
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Order ID:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0067b8; text-align: right; font-family: monospace;">#{{ $order->order_number }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Subscribed Plan:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0f172a; text-align: right;">{{ $order->plan_name }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Amount Paid:</td>
                <td style="padding: 6px 0; font-weight: 800; color: #059669; text-align: right; font-size: 15px;">৳{{ number_format($order->payable_amount, 2) }} BDT</td>
            </tr>
            @if($order->gateway_txn_id)
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Transaction ID:</td>
                <td style="padding: 6px 0; font-weight: 600; color: #334155; text-align: right; font-family: monospace;">{{ $order->gateway_txn_id }}</td>
            </tr>
            @endif
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Payment Date:</td>
                <td style="padding: 6px 0; font-weight: 600; color: #334155; text-align: right;">{{ ($order->paid_at ?? now())->format('M d, Y - h:i A') }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Assigned License Email:</td>
                <td style="padding: 6px 0; font-weight: 600; color: #0067b8; text-align: right;">{{ $order->recipient_email }}</td>
            </tr>
        </table>
    </div>

    <div style="background-color: #eff6ff; border-left: 4px solid #0067b8; border-radius: 8px; padding: 14px 16px; margin: 20px 0; font-size: 13px; color: #1e3a8a; line-height: 1.5;">
        <strong>What's Next?</strong><br>
        Our Microsoft licensing specialists are provisioning your cloud activation. As soon as your subscription is activated, you will receive a separate confirmation with full setup instructions.
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ route('user.subscriptions') }}" class="btn" style="background-color: #0067b8; color: #ffffff; padding: 12px 28px; border-radius: 10px; font-weight: bold; text-decoration: none; display: inline-block;">
            View My Subscriptions &rarr;
        </a>
    </div>

    <p style="margin-top: 24px; font-size: 12px; color: #94a3b8; text-align: center;">
        Thank you for choosing {{ site_setting('site_name', 'Microsoft Office Club') }}.
    </p>
@endsection
