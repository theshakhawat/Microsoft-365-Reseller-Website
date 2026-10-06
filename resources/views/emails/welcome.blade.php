@extends('emails.layout')

@section('title', 'Welcome to ' . site_setting('site_name', 'Microsoft Office Club'))

@section('content')
    <h2 style="margin-top: 0; font-size: 20px; font-weight: 800; color: #0f172a;">
        Welcome aboard, {{ $user->name }}! 🎉
    </h2>

    <p>
        Thank you for joining <strong>{{ site_setting('site_name', 'Microsoft Office Club') }}</strong>. Your customer account is now active and ready.
    </p>

    <div class="card">
        <p style="margin: 0 0 6px 0; font-size: 13px; color: #64748b;"><strong>Account Details:</strong></p>
        <p style="margin: 0; font-size: 14px;"><strong>Email:</strong> {{ $user->email }}</p>
        @if(!empty($password))
            <p style="margin: 4px 0 0 0; font-size: 14px;"><strong>Temporary Password:</strong> <code style="background: #e2e8f0; padding: 2px 6px; border-radius: 4px; font-family: monospace;">{{ $password }}</code></p>
        @endif
        @if($user->phone)
            <p style="margin: 4px 0 0 0; font-size: 14px;"><strong>Phone:</strong> {{ $user->phone }}</p>
        @endif
        <p style="margin: 4px 0 0 0; font-size: 14px;"><strong>Role:</strong> Customer</p>
    </div>

    <p>
        You can now log in to your account, browse genuine Microsoft 365 Personal subscriptions, manage licenses, and request dedicated 24/7 support.
    </p>

    <div style="text-align: center;">
        <a href="{{ route('user.dashboard') }}" class="btn">Go to Customer Dashboard &rarr;</a>
    </div>

    <p style="margin-top: 30px; font-size: 13px; color: #64748b;">
        If you did not create this account, please contact our support team immediately.
    </p>
@endsection
