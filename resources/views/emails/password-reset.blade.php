@extends('emails.layout')

@section('title', 'Reset Your Password')

@section('content')
    <h2 style="margin-top: 0; font-size: 20px; font-weight: 800; color: #0f172a;">
        Password Reset Request
    </h2>

    <p>
        Hello,
    </p>

    <p>
        You are receiving this email because we received a password reset request for your customer account at <strong>{{ site_setting('site_name', 'Microsoft Office Club') }}</strong>.
    </p>

    <div style="text-align: center; margin: 28px 0;">
        <a href="{{ $resetUrl }}" class="btn">Reset Password &rarr;</a>
    </div>

    <p style="font-size: 13px; color: #64748b;">
        This password reset link will expire in 60 minutes. If you did not request a password reset, no further action is required.
    </p>
@endsection
