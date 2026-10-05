@extends('emails.layout')

@section('title', 'Order Cancelled - #' . $order->order_number)

@section('content')
    <h2 style="margin-top: 0; font-size: 20px; font-weight: 800; color: #dc2626;">
        Order #{{ $order->order_number }} Cancelled
    </h2>

    <p>
        Hello {{ $order->user->name ?? 'Customer' }},
    </p>

    <p>
        This email confirms that order <strong>#{{ $order->order_number }}</strong> has been cancelled.
    </p>

    <div class="card">
        <p style="margin: 0; font-size: 13px; color: #64748b;"><strong>Plan:</strong> {{ $order->pricingPlan->name ?? 'N/A' }}</p>
        <p style="margin: 4px 0 0 0; font-size: 13px; color: #64748b;"><strong>Status:</strong> <span style="color: #dc2626; font-weight: bold;">Cancelled</span></p>
    </div>

    <p>
        If you wish to re-order or need help completing payment, please browse our pricing plans or contact customer support.
    </p>

    <div style="text-align: center;">
        <a href="{{ route('user.plans') }}" class="btn">Browse Available Plans &rarr;</a>
    </div>
@endsection
