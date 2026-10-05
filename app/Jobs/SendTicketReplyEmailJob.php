<?php

namespace App\Jobs;

use App\Models\SiteSetting;
use App\Models\SmtpSetting;
use App\Models\Ticket;
use App\Models\TicketReply;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTicketReplyEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Number of retry attempts
     */
    public int $tries = 3;

    /**
     * Timeout in seconds
     */
    public int $timeout = 60;

    /**
     * The ticket instance
     */
    public Ticket $ticket;

    /**
     * The ticket reply instance
     */
    public TicketReply $reply;

    /**
     * Create a new job instance.
     */
    public function __construct(Ticket $ticket, TicketReply $reply)
    {
        $this->ticket = $ticket;
        $this->reply = $reply;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Apply fresh database SMTP configuration
        SmtpSetting::applyConfig();

        $ticket = $this->ticket->fresh(['user']);
        $reply = $this->reply->fresh();

        if (!$ticket || !$reply) {
            Log::warning("SendTicketReplyEmailJob: Ticket or reply not found.");
            return;
        }

        $user = $ticket->user;
        if (!$user || empty($user->email)) {
            Log::warning("SendTicketReplyEmailJob: No recipient user email found for Ticket #{$ticket->ticket_number}");
            return;
        }

        $appName = site_setting('site_name', config('app.name', 'Microsoft Office Club'));
        $fromAddress = config('mail.from.address', 'support@microsoftoffice.club');

        try {
            $htmlContent = view('emails.ticket-reply', compact('ticket', 'reply'))->render();

            Mail::html($htmlContent, function ($message) use ($user, $ticket, $appName, $fromAddress) {
                $message->to($user->email, $user->name)
                        ->from($fromAddress, $appName)
                        ->subject("Support Reply: Ticket #{$ticket->ticket_number} - {$ticket->subject}");
            });

            Log::info("Ticket reply email sent successfully to {$user->email} for Ticket #{$ticket->ticket_number}");
        } catch (\Throwable $e) {
            Log::error("Failed to send ticket reply email for Ticket #{$ticket->ticket_number} to {$user->email}: " . $e->getMessage());
            throw $e;
        }
    }
}
