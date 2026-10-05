@extends('emails.layout')

@section('title', 'Admin Alert: ' . ($title ?? 'System Notification'))

@section('content')
    <h2 style="margin-top: 0; font-size: 20px; font-weight: 800; color: #0067b8;">
        {{ $title ?? 'Admin System Alert' }}
    </h2>

    <p style="font-size: 14px; line-height: 1.6;">
        {{ $content ?? $message ?? 'An event requires administrator attention.' }}
    </p>

    @if(!empty($actionUrl))
        <div style="text-align: center; margin-top: 24px;">
            <a href="{{ $actionUrl }}" class="btn">Open Admin Control Center &rarr;</a>
        </div>
    @endif
@endsection
