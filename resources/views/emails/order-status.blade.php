@extends('emails.layout')

@section('title', 'Order Update - #' . $order->order_number)

@section('content')
    <h2 style="margin-top: 0; font-size: 20px; font-weight: 800; color: #0f172a;">
        Order Update: {{ ucfirst($order->status) }}
    </h2>

    <p>
        Hello {{ $order->user->name ?? 'Customer' }},
    </p>

    <p>
        Here is the latest status update regarding your order <strong>#{{ $order->order_number }}</strong>.
    </p>

    <div class="card">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <tr>
                <td style="padding: 4px 0; color: #64748b;">Plan:</td>
                <td style="padding: 4px 0; font-weight: 700; text-align: right;">{{ $order->pricingPlan->name ?? 'Subscription Plan' }}</td>
            </tr>
            <tr>
                <td style="padding: 4px 0; color: #64748b;">Amount:</td>
                <td style="padding: 4px 0; font-weight: 700; text-align: right;">৳{{ number_format($order->final_amount, 2) }}</td>
            </tr>
            <tr>
                <td style="padding: 4px 0; color: #64748b;">Payment Status:</td>
                <td style="padding: 4px 0; font-weight: 700; text-align: right;">{{ ucfirst($order->payment_status) }}</td>
            </tr>
            <tr>
                <td style="padding: 4px 0; color: #64748b;">Order Status:</td>
                <td style="padding: 4px 0; font-weight: 700; text-align: right;">{{ ucfirst($order->status) }}</td>
            </tr>
        </table>
    </div>

    <div style="text-align: center;">
        <a href="{{ route('user.invoice', $order->id) }}" class="btn">View Invoice & Details &rarr;</a>
    </div>
@endsection
