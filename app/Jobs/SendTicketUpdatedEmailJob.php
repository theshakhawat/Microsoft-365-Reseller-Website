<?php

namespace App\Jobs;

use App\Models\SiteSetting;
use App\Models\SmtpSetting;
use App\Models\Ticket;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTicketUpdatedEmailJob implements ShouldQueue
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
     * Ticket model
     */
    public Ticket $ticket;

    /**
     * Optional message or details
     */
    public ?string $updateNote;

    /**
     * Create a new job instance.
     */
    public function __construct(Ticket $ticket, ?string $updateNote = null)
    {
        $this->ticket = $ticket;
        $this->updateNote = $updateNote;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Apply fresh database SMTP configuration
        SmtpSetting::applyConfig();

        $ticket = $this->ticket->fresh(['user']);

        if (!$ticket || !$ticket->user || !$ticket->user->email) {
            Log::warning("SendTicketUpdatedEmailJob: Ticket or User not found for ticket ID {$this->ticket->id}");
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

        $statusLabel = strtoupper(str_replace('_', ' ', $ticket->status));
        $priorityLabel = strtoupper($ticket->priority);
        $note = $this->updateNote ?: "The status of your ticket has been updated to {$statusLabel}.";

        $htmlContent = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Ticket Status Updated - #{$ticket->ticket_number}</title>
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
                                    <h1 style='color: #ffffff; font-size: 22px; font-weight: 800; margin: 4px 0 0 0; letter-spacing: -0.5px;'>
                                        Ticket Status Updated: #{$ticket->ticket_number}
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
                                        " . e($note) . "
                                    </p>

                                    <!-- Ticket Summary Details Box -->
                                    <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 26px;'>
                                        <table role='presentation' width='100%' style='font-size: 13px; border-collapse: collapse;'>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b;'>Ticket ID:</td>
                                                <td style='padding: 8px 0; color: #1e293b; font-weight: bold; text-align: right;'>#{$ticket->ticket_number}</td>
                                            </tr>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b;'>Subject:</td>
                                                <td style='padding: 8px 0; color: #1e293b; font-weight: 600; text-align: right;'>" . e($ticket->subject) . "</td>
                                            </tr>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b;'>Department:</td>
                                                <td style='padding: 8px 0; color: #1e293b; font-weight: 600; text-align: right;'>" . e($ticket->department) . "</td>
                                            </tr>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b;'>Priority:</td>
                                                <td style='padding: 8px 0; color: #0067b8; font-weight: 700; text-align: right;'>{$priorityLabel}</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 8px 0; color: #64748b;'>Current Status:</td>
                                                <td style='padding: 8px 0; color: #16a34a; font-weight: 700; text-align: right;'>{$statusLabel}</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Main CTA Button -->
                                    <div style='text-align: center; margin: 28px 0;'>
                                        <a href='{$ticketUrl}' style='background-color: #0067b8; color: #ffffff; padding: 14px 32px; border-radius: 10px; font-weight: bold; font-size: 14px; text-decoration: none; display: inline-block; box-shadow: 0 4px 12px rgba(0, 103, 184, 0.35);'>
                                            View Support Ticket &rarr;
                                        </a>
                                    </div>

                                    <!-- Help Info -->
                                    <div style='border-top: 1px solid #e2e8f0; padding-top: 20px; font-size: 12px; color: #64748b; line-height: 1.5;'>
                                        <p style='margin: 0 0 6px 0; font-weight: bold; color: #334155;'>Questions?</p>
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
                                    <p style='margin: 0; color: #64748b;'>You received this email regarding your support ticket on {$appName}.</p>
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
            Mail::html($htmlContent, function ($message) use ($user, $appName, $fromAddress, $ticket, $statusLabel) {
                $message->to($user->email, $user->name)
                        ->from($fromAddress, $appName)
                        ->subject("[Ticket #{$ticket->ticket_number}] Status Update: {$statusLabel}");
            });

            Log::info("Ticket status updated email sent for Ticket #{$ticket->ticket_number} to {$user->email}");
        } catch (\Throwable $e) {
            Log::error("Failed to send ticket status email for Ticket #{$ticket->ticket_number} to {$user->email}: " . $e->getMessage());
            throw $e;
        }
    }
}
