@extends('emails.layout')

@section('title', 'Order Approved & Subscription Activated - #' . $order->order_number)

@section('content')
    <h2 style="margin-top: 0; font-size: 20px; font-weight: 800; color: #16a34a;">
        Your Order Has Been Approved! 🚀
    </h2>

    <p>
        Hello {{ $order->user->name ?? 'Customer' }},
    </p>

    <p>
        Great news! Your payment for order <strong>#{{ $order->order_number }}</strong> has been verified, and your Microsoft 365 subscription is now <strong>Active</strong>.
    </p>

    <div class="card">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <tr>
                <td style="padding: 4px 0; color: #64748b;">Plan:</td>
                <td style="padding: 4px 0; font-weight: 700; text-align: right;">{{ $order->pricingPlan->name ?? 'Microsoft 365 Personal' }}</td>
            </tr>
            <tr>
                <td style="padding: 4px 0; color: #64748b;">Duration:</td>
                <td style="padding: 4px 0; font-weight: 700; text-align: right;">{{ $order->pricingPlan->duration_days ?? 365 }} Days</td>
            </tr>
            <tr>
                <td style="padding: 4px 0; color: #64748b;">Paid Amount:</td>
                <td style="padding: 4px 0; font-weight: 700; text-align: right; color: #16a34a;">৳{{ number_format($order->final_amount, 2) }}</td>
            </tr>
        </table>
    </div>

    <p>
        You can now access all premium Office apps (Word, Excel, PowerPoint, Outlook, 1TB OneDrive) linked to your email.
    </p>

    <div style="text-align: center;">
        <a href="{{ route('user.subscriptions') }}" class="btn">View My Active Subscription &rarr;</a>
    </div>
@endsection
