@extends('emails.layout')

@section('title', 'Payment Failed / Incomplete - #' . $order->order_number . ' | ' . site_setting('site_name', 'Microsoft Office Club'))

@section('content')
    <div style="background: linear-gradient(135deg, #e11d48 0%, #f43f5e 100%); margin: -32px -32px 24px -32px; padding: 24px 32px; text-align: center; color: #ffffff;">
        <h2 style="margin: 0; font-size: 18px; font-weight: 800; color: #ffffff;">
            ⚠️ Payment Could Not Be Completed
        </h2>
        <p style="margin: 4px 0 0 0; font-size: 12px; color: #ffe4e6;">
            Order #{{ $order->order_number }}
        </p>
    </div>

    <p style="font-size: 14px; color: #334155;">
        Hello <strong>{{ $order->recipient_name ?: ($order->user->name ?? 'Valued Customer') }}</strong>,
    </p>

    <p style="font-size: 14px; color: #334155; line-height: 1.6;">
        We were unable to process your payment for Order <strong>#{{ $order->order_number }}</strong>. Your transaction was declined or interrupted during checkout.
    </p>

    <div class="card" style="margin: 20px 0; padding: 20px; background: #fff1f2; border: 1px solid #fecdd3; border-radius: 12px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <tr>
                <td style="padding: 6px 0; color: #881337; font-weight: 600;">Order Number:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #e11d48; text-align: right; font-family: monospace;">#{{ $order->order_number }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #881337; font-weight: 600;">Selected Plan:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0f172a; text-align: right;">{{ $order->plan_name }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #881337; font-weight: 600;">Payable Amount:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0f172a; text-align: right;">৳{{ number_format($order->payable_amount, 2) }} BDT</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #881337; font-weight: 600;">Status:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #e11d48; text-align: right;">Payment Failed / Incomplete</td>
            </tr>
        </table>
    </div>

    <p style="font-size: 13px; color: #475569; line-height: 1.6;">
        No worries! You can retry your payment easily from your customer dashboard using another payment method like bKash, Nagad, Rocket, or Visa/Mastercard.
    </p>

    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ route('user.orders') }}" class="btn" style="background-color: #e11d48; color: #ffffff; padding: 12px 28px; border-radius: 10px; font-weight: bold; text-decoration: none; display: inline-block;">
            Retry Payment Now &rarr;
        </a>
    </div>

    <p style="margin-top: 24px; font-size: 12px; color: #94a3b8; text-align: center;">
        If you were charged by your bank or wallet, please contact our support team at {{ site_setting('contact_email', 'support@microsoftoffice.club') }} with your transaction details.
    </p>
@endsection
