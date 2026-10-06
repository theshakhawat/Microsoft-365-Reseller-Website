@extends('emails.layout')

@section('title', 'Order Placed - #' . $order->order_number . ' | ' . site_setting('site_name', 'Microsoft Office Club'))

@section('content')
    <div style="background: linear-gradient(135deg, #0f172a 0%, #0067b8 100%); margin: -32px -32px 24px -32px; padding: 24px 32px; text-align: center; color: #ffffff;">
        <h2 style="margin: 0; font-size: 18px; font-weight: 800; color: #ffffff;">
            🛒 Order Placed Successfully!
        </h2>
        <p style="margin: 4px 0 0 0; font-size: 12px; color: #bae0fd;">
            Order #{{ $order->order_number }}
        </p>
    </div>

    <p style="font-size: 14px; color: #334155;">
        Hello <strong>{{ $order->recipient_name ?: ($order->user->name ?? 'Valued Customer') }}</strong>,
    </p>

    <p style="font-size: 14px; color: #334155; line-height: 1.6;">
        Thank you for choosing <strong>{{ site_setting('site_name', 'Microsoft Office Club') }}</strong>! We have received your order. Here are your order and invoice details:
    </p>

    <div class="card" style="margin: 20px 0; padding: 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Order Number:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0067b8; text-align: right; font-family: monospace;">#{{ $order->order_number }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Plan Selected:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0f172a; text-align: right;">{{ $order->plan_name }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Regular Price:</td>
                <td style="padding: 6px 0; font-weight: 600; color: #475569; text-align: right;">৳{{ number_format($order->plan_price, 2) }}</td>
            </tr>
            @if($order->discount_amount > 0)
            <tr>
                <td style="padding: 6px 0; color: #16a34a; font-weight: 600;">Promo Discount:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #16a34a; text-align: right;">-৳{{ number_format($order->discount_amount, 2) }} ({{ $order->coupon_code }})</td>
            </tr>
            @endif
            <tr style="border-top: 2px solid #e2e8f0;">
                <td style="padding: 10px 0 6px 0; color: #0f172a; font-weight: 800; font-size: 14px;">Payable Amount:</td>
                <td style="padding: 10px 0 6px 0; font-weight: 800; color: #0067b8; text-align: right; font-size: 16px;">৳{{ number_format($order->payable_amount, 2) }} BDT</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Payment Status:</td>
                <td style="padding: 6px 0; text-align: right;">
                    @if($order->payment_status === 'paid')
                        <span style="background-color: #dcfce7; color: #15803d; font-weight: 700; font-size: 11px; padding: 3px 8px; border-radius: 9999px;">PAID</span>
                    @elseif($order->payment_status === 'pending')
                        <span style="background-color: #fef3c7; color: #b45309; font-weight: 700; font-size: 11px; padding: 3px 8px; border-radius: 9999px;">PENDING</span>
                    @else
                        <span style="background-color: #f1f5f9; color: #475569; font-weight: 700; font-size: 11px; padding: 3px 8px; border-radius: 9999px;">{{ strtoupper($order->payment_status) }}</span>
                    @endif
                </td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">License Recipient:</td>
                <td style="padding: 6px 0; font-weight: 600; color: #0f172a; text-align: right;">{{ $order->recipient_email }}</td>
            </tr>
        </table>
    </div>

    @if($order->payment_status !== 'paid')
    <p style="font-size: 13px; color: #475569; line-height: 1.6;">
        If you haven't completed your payment yet, please proceed to your dashboard to complete the transaction via bKash, Nagad, Rocket, or Bank transfer.
    </p>
    @endif

    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ route('user.orders') }}" class="btn" style="background-color: #0067b8; color: #ffffff; padding: 12px 28px; border-radius: 10px; font-weight: bold; text-decoration: none; display: inline-block;">
            View Order & Invoice &rarr;
        </a>
    </div>

    <p style="margin-top: 24px; font-size: 12px; color: #94a3b8; text-align: center;">
        Have questions? Contact our 24/7 support at {{ site_setting('contact_email', 'support@microsoftoffice.club') }}.
    </p>
@endsection
