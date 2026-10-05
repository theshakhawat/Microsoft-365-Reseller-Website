@extends('emails.layout')

@section('title', 'Subscription Status Update')

@section('content')
    <h2 style="margin-top: 0; font-size: 20px; font-weight: 800; color: #0f172a;">
        Subscription Status: {{ ucfirst($status ?? $subscription->status) }}
    </h2>

    <p>
        Hello {{ $subscription->user->name ?? 'Customer' }},
    </p>

    <p>
        This is an update regarding your Microsoft 365 subscription.
    </p>

    <div class="card">
        <p style="margin: 0; font-size: 13px;"><strong>Plan:</strong> {{ $subscription->pricingPlan->name ?? 'Microsoft 365 Personal' }}</p>
        <p style="margin: 4px 0 0 0; font-size: 13px;"><strong>Status:</strong> {{ ucfirst($subscription->status) }}</p>
        @if($subscription->ends_at)
            <p style="margin: 4px 0 0 0; font-size: 13px;"><strong>Expires On:</strong> {{ $subscription->ends_at->format('M d, Y') }}</p>
        @endif
        @if(!empty($reason))
            <p style="margin: 6px 0 0 0; font-size: 13px; color: #64748b;"><strong>Note:</strong> {{ $reason }}</p>
        @endif
    </div>

    <div style="text-align: center;">
        <a href="{{ route('user.subscriptions') }}" class="btn">View Subscription Details &rarr;</a>
    </div>
@endsection
