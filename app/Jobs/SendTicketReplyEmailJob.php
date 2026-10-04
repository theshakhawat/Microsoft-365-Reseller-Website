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
     * Ticket and Reply models
     */
    public Ticket $ticket;
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
        $reply = $this->reply->fresh(['user']);

        if (!$ticket || !$ticket->user || !$ticket->user->email) {
            Log::warning("SendTicketReplyEmailJob: Ticket or User not found for ticket ID {$this->ticket->id}");
            return;
        }

        $user = $ticket->user;
        $appName = site_setting('site_name', config('app.name', 'Microsoft Office Club'));
        $fromAddress = config('mail.from.address', 'support@microsoftoffice.club');
        $ticketUrl = route('user.tickets.show', $ticket->id);
        $supportEmail = site_setting('contact_email', 'support@cloudsync.com.bd');
        $supportPhone = site_setting('contact_phone', '09649-0123756');
        $whatsappNumber = site_setting('whatsapp_number', '+880 1342-325558');
        $whatsappRaw = site_setting('whatsapp_raw_number', '8801342325558');

        $staffName = $reply->user ? $reply->user->name : 'Support Helpdesk';
        $replyMessageHtml = nl2br(e($reply->message));
        $statusLabel = strtoupper(str_replace('_', ' ', $ticket->status));
        $priorityLabel = strtoupper($ticket->priority);

        $htmlContent = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>New Reply on Ticket #{$ticket->ticket_number}</title>
        </head>
        <body style='margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif;'>
            <table role='presentation' width='100%' cellspacing='0' cellpadding='0' style='background-color: #f1f5f9; padding: 30px 15px;'>
                <tr>
                    <td align='center'>
                        <table role='presentation' width='100%' max-width='600' style='max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;'>
                            
                            <!-- Header Banner (Microsoft Blue Gradient) -->
                            <tr>
                                <td style='background: linear-gradient(135deg, #0b192c 0%, #0067b8 100%); padding: 32px 30px; text-align: center;'>
                                    <div style='display: inline-block; margin-bottom: 10px;'>
                                        <table role='presentation' cellspacing='0' cellpadding='0' style='margin: 0 auto;'>
                                            <tr>
                                                <td style='background-color: #f25022; width: 10px; height: 10px; border-radius: 1px;'></td>
                                                <td style='width: 3px;'></td>
                                                <td style='background-color: #7fba00; width: 10px; height: 10px; border-radius: 1px;'></td>
                                            </tr>
                                            <tr><td style='height: 3px;'></td></tr>
                                            <tr>
                                                <td style='background-color: #00a4ef; width: 10px; height: 10px; border-radius: 1px;'></td>
                                                <td style='width: 3px;'></td>
                                                <td style='background-color: #ffb900; width: 10px; height: 10px; border-radius: 1px;'></td>
                                            </tr>
                                        </table>
                                    </div>
                                    <div style='display: inline-block; background-color: rgba(56, 189, 248, 0.2); border: 1px solid #38bdf8; color: #bae6fd; padding: 4px 12px; border-radius: 9999px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;'>
                                        🎧 Helpdesk Support Update
                                    </div>
                                    <h1 style='color: #ffffff; font-size: 22px; font-weight: 800; margin: 4px 0 0 0; letter-spacing: -0.5px;'>
                                        New Reply on Ticket #{$ticket->ticket_number}
                                    </h1>
                                    <p style='color: #bae0fd; font-size: 13px; margin: 6px 0 0 0;'>
                                        " . e($ticket->subject) . "
                                    </p>
                                </td>
                            </tr>

                            <!-- Body Content -->
                            <tr>
                                <td style='padding: 32px 30px;'>
                                    <p style='color: #1e293b; font-size: 15px; font-weight: bold; margin: 0 0 12px 0;'>
                                        Hello " . e($user->name) . ",
                                    </p>
                                    <p style='color: #475569; font-size: 14px; line-height: 1.6; margin: 0 0 20px 0;'>
                                        Our support staff has replied to your support ticket. Please find the response below:
                                    </p>

                                    <!-- Support Reply Message Box -->
                                    <div style='background-color: #f8fafc; border-left: 4px solid #0067b8; border-radius: 0 12px 12px 0; padding: 20px; margin-bottom: 24px; border-top: 1px solid #e2e8f0; border-right: 1px solid #e2e8f0; border-bottom: 1px solid #e2e8f0;'>
                                        <div style='font-size: 12px; font-weight: bold; color: #0067b8; margin-bottom: 8px;'>
                                            " . e($staffName) . " <span style='color: #64748b; font-weight: normal;'>(" . now()->format('M d, Y - h:i A') . ")</span>
                                        </div>
                                        <div style='color: #1e293b; font-size: 14px; line-height: 1.6;'>
                                            {$replyMessageHtml}
                                        </div>
                                        " . ($reply->attachment ? "
                                        <div style='margin-top: 14px; padding-top: 10px; border-top: 1px dashed #cbd5e1; font-size: 12px; color: #475569;'>
                                            📎 <strong>Attachment:</strong> File attached. Please view it on the portal.
                                        </div>
                                        " : "") . "
                                    </div>

                                    <!-- Ticket Summary Details Box -->
                                    <div style='background-color: #f1f5f9; border-radius: 12px; padding: 18px; margin-bottom: 26px;'>
                                        <table role='presentation' width='100%' style='font-size: 12px; border-collapse: collapse;'>
                                            <tr>
                                                <td style='padding: 5px 0; color: #64748b;'>Ticket ID:</td>
                                                <td style='padding: 5px 0; color: #1e293b; font-weight: bold; text-align: right;'>#{$ticket->ticket_number}</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 5px 0; color: #64748b;'>Department:</td>
                                                <td style='padding: 5px 0; color: #1e293b; font-weight: 600; text-align: right;'>" . e($ticket->department) . "</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 5px 0; color: #64748b;'>Priority:</td>
                                                <td style='padding: 5px 0; color: #0067b8; font-weight: 700; text-align: right;'>{$priorityLabel}</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 5px 0; color: #64748b;'>Status:</td>
                                                <td style='padding: 5px 0; color: #16a34a; font-weight: 700; text-align: right;'>{$statusLabel}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Main CTA Button -->
                                    <div style='text-align: center; margin: 28px 0;'>
                                        <a href='{$ticketUrl}' style='background-color: #0067b8; color: #ffffff; padding: 14px 32px; border-radius: 10px; font-weight: bold; font-size: 14px; text-decoration: none; display: inline-block; box-shadow: 0 4px 12px rgba(0, 103, 184, 0.35);'>
                                            View Ticket & Reply &rarr;
                                        </a>
                                    </div>

                                    <!-- Help Info -->
                                    <div style='border-top: 1px solid #e2e8f0; padding-top: 20px; font-size: 12px; color: #64748b; line-height: 1.5;'>
                                        <p style='margin: 0 0 6px 0; font-weight: bold; color: #334155;'>Need further assistance?</p>
                                        <p style='margin: 0;'>
                                            WhatsApp: <a href='https://wa.me/{$whatsappRaw}' style='color: #0067b8; text-decoration: none; font-weight: 600;'>{$whatsappNumber}</a> &bull;
                                            Phone: <a href='tel:{$supportPhone}' style='color: #0067b8; text-decoration: none; font-weight: 600;'>{$supportPhone}</a> &bull;
                                            Email: <a href='mailto:{$supportEmail}' style='color: #0067b8; text-decoration: none; font-weight: 600;'>{$supportEmail}</a>
                                        </p>
                                    </div>

                                </td>
                            </tr>

                            <!-- Footer -->
                            <tr>
                                <td style='background-color: #0f172a; padding: 24px 30px; text-align: center; color: #94a3b8; font-size: 11px;'>
                                    <p style='margin: 0 0 6px 0;'>© " . date('Y') . " {$appName}. All rights reserved.</p>
                                    <p style='margin: 0; color: #64748b;'>You received this email because you submitted a support ticket on {$appName}.</p>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </body>
        </html>
        ";

        try {
            Mail::html($htmlContent, function ($message) use ($user, $appName, $fromAddress, $ticket) {
                $message->to($user->email, $user->name)
                        ->from($fromAddress, $appName)
                        ->subject("[Ticket #{$ticket->ticket_number}] New Support Reply: {$ticket->subject}");
            });

            Log::info("Ticket reply email queued/sent successfully for Ticket #{$ticket->ticket_number} to {$user->email}");
        } catch (\Throwable $e) {
            Log::error("Failed to send ticket reply email for Ticket #{$ticket->ticket_number} to {$user->email}: " . $e->getMessage());
            throw $e;
        }
    }
}
