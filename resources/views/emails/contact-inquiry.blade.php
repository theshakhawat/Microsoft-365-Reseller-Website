@extends('emails.layout')

@section('title', 'New Contact Form Inquiry - ' . site_setting('site_name', 'Microsoft Office Club'))

@section('content')
    <div style="background: linear-gradient(135deg, #0f172a 0%, #0067b8 100%); margin: -32px -32px 24px -32px; padding: 24px 32px; text-align: center; color: #ffffff;">
        <h2 style="margin: 0; font-size: 18px; font-weight: 800; color: #ffffff;">
            📩 New Contact Message Received
        </h2>
        <p style="margin: 4px 0 0 0; font-size: 12px; color: #bae0fd;">
            Submitted from storefront Contact & Support form
        </p>
    </div>

    <p style="font-size: 14px; color: #334155; margin-bottom: 16px;">
        Hello Admin, you have received a new inquiry from a visitor/customer on <strong>{{ site_setting('site_name', 'Microsoft Office Club') }}</strong>:
    </p>

    <div class="card" style="margin: 16px 0; padding: 18px 20px; background: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px;">
        <table style="width: 100%; border-collapse: collapse; font-size: 13px;">
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600; width: 110px;">Sender Name:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0f172a;">{{ $contactMessage->name }}</td>
            </tr>
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Email Address:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0067b8;">
                    <a href="mailto:{{ $contactMessage->email }}" style="color: #0067b8; text-decoration: none;">{{ $contactMessage->email }}</a>
                </td>
            </tr>
            @if($contactMessage->phone)
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Phone Number:</td>
                <td style="padding: 6px 0; font-weight: 700; color: #0f172a;">
                    <a href="tel:{{ $contactMessage->phone }}" style="color: #0f172a; text-decoration: none;">{{ $contactMessage->phone }}</a>
                </td>
            </tr>
            @endif
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">Received At:</td>
                <td style="padding: 6px 0; color: #475569;">{{ ($contactMessage->created_at ?? now())->format('M d, Y - h:i A') }}</td>
            </tr>
            @if($contactMessage->ip_address)
            <tr>
                <td style="padding: 6px 0; color: #64748b; font-weight: 600;">IP Address:</td>
                <td style="padding: 6px 0; color: #94a3b8; font-family: monospace; font-size: 12px;">{{ $contactMessage->ip_address }}</td>
            </tr>
            @endif
        </table>
    </div>

    <div style="margin: 20px 0;">
        <p style="margin: 0 0 8px 0; font-size: 13px; font-weight: 700; color: #0f172a;">Message Content:</p>
        <div style="background-color: #ffffff; border: 1px solid #cbd5e1; border-left: 4px solid #0067b8; border-radius: 8px; padding: 14px 16px; font-size: 13px; color: #1e293b; line-height: 1.6; white-space: pre-line;">
            {{ $contactMessage->message }}
        </div>
    </div>

    <div style="text-align: center; margin-top: 24px;">
        <a href="{{ route('admin.contact-messages.show', $contactMessage->id) }}" class="btn" style="background-color: #0067b8; color: #ffffff; padding: 12px 26px; border-radius: 10px; font-weight: bold; text-decoration: none; display: inline-block;">
            Open Message in Admin Panel &rarr;
        </a>
    </div>

    <p style="margin-top: 24px; font-size: 12px; color: #94a3b8; text-align: center;">
        You can reply directly to this email or contact the user using the details above.
    </p>
@endsection
