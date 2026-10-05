@extends('emails.layout')

@section('title', 'Reply on Ticket #' . $ticket->ticket_id)

@section('content')
    <h2 style="margin-top: 0; font-size: 20px; font-weight: 800; color: #0f172a;">
        New Reply on Support Ticket #{{ $ticket->ticket_id }}
    </h2>

    <p>
        Hello {{ $ticket->user->name ?? 'Customer' }},
    </p>

    <p>
        Our support team has posted a new reply regarding your support ticket: <strong>"{{ $ticket->subject }}"</strong>.
    </p>

    <div class="card" style="border-left: 4px solid #0067b8;">
        <p style="margin: 0 0 6px 0; font-size: 12px; color: #64748b; font-weight: bold;">
            Support Team Reply:
        </p>
        <p style="margin: 0; font-size: 14px; white-space: pre-line; color: #1e293b;">
            {{ $reply->message ?? 'A new reply has been posted.' }}
        </p>
    </div>

    <div style="text-align: center;">
        <a href="{{ route('user.tickets.show', $ticket->id) }}" class="btn">View & Reply in Portal &rarr;</a>
    </div>
@endsection
