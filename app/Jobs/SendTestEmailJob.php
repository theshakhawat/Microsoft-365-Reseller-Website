<?php

namespace App\Jobs;

use App\Models\SmtpSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendTestEmailJob implements ShouldQueue
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
     * Recipient email address
     */
    public string $recipient;

    /**
     * Create a new job instance.
     */
    public function __construct(string $recipient)
    {
        $this->recipient = $recipient;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Apply fresh database SMTP configuration
        SmtpSetting::applyConfig();

        $appName = config('mail.from.name', config('app.name', 'Microsoft Office Club'));
        $fromAddress = config('mail.from.address', 'support@microsoftoffice.club');
        $timestamp = now()->format('Y-m-d H:i:s T');
        $recipient = $this->recipient;

        $htmlContent = "
            <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background-color: #ffffff;'>
                <div style='text-align: center; margin-bottom: 20px;'>
                    <h2 style='color: #0067b8; margin: 0;'>{$appName}</h2>
                    <p style='color: #64748b; font-size: 14px; margin-top: 4px;'>Queued SMTP Test Email</p>
                </div>
                <div style='background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 16px; margin-bottom: 20px;'>
                    <p style='color: #166534; font-weight: bold; margin: 0 0 8px 0;'>✓ Queued Delivery Successful!</p>
                    <p style='color: #15803d; font-size: 13px; margin: 0;'>This test email was successfully processed through Laravel Background Job Queue (Worker).</p>
                </div>
                <table style='width: 100%; border-collapse: collapse; font-size: 13px; margin-bottom: 20px;'>
                    <tr style='border-bottom: 1px solid #f1f5f9;'>
                        <td style='padding: 8px 0; color: #64748b; font-weight: bold;'>Execution Mode:</td>
                        <td style='padding: 8px 0; color: #166534; font-weight: bold; text-align: right;'>Laravel Job Queue (Asynchronous)</td>
                    </tr>
                    <tr style='border-bottom: 1px solid #f1f5f9;'>
                        <td style='padding: 8px 0; color: #64748b; font-weight: bold;'>Mailer Driver:</td>
                        <td style='padding: 8px 0; color: #1e293b; text-align: right;'>" . strtoupper(config('mail.default', 'smtp')) . "</td>
                    </tr>
                    <tr style='border-bottom: 1px solid #f1f5f9;'>
                        <td style='padding: 8px 0; color: #64748b; font-weight: bold;'>SMTP Host:</td>
                        <td style='padding: 8px 0; color: #1e293b; text-align: right;'>" . (config('mail.mailers.smtp.host') ?: 'N/A') . "</td>
                    </tr>
                    <tr style='border-bottom: 1px solid #f1f5f9;'>
                        <td style='padding: 8px 0; color: #64748b; font-weight: bold;'>SMTP Port:</td>
                        <td style='padding: 8px 0; color: #1e293b; text-align: right;'>" . (config('mail.mailers.smtp.port') ?: 'N/A') . "</td>
                    </tr>
                    <tr style='border-bottom: 1px solid #f1f5f9;'>
                        <td style='padding: 8px 0; color: #64748b; font-weight: bold;'>From Address:</td>
                        <td style='padding: 8px 0; color: #1e293b; text-align: right;'>{$fromAddress}</td>
                    </tr>
                    <tr>
                        <td style='padding: 8px 0; color: #64748b; font-weight: bold;'>Timestamp:</td>
                        <td style='padding: 8px 0; color: #1e293b; text-align: right;'>{$timestamp}</td>
                    </tr>
                </table>
                <p style='color: #94a3b8; font-size: 12px; text-align: center; margin: 0;'>Delivered via {$appName} Queued Mail Worker.</p>
            </div>
        ";

        Mail::html($htmlContent, function ($message) use ($recipient, $appName, $fromAddress) {
            $message->to($recipient)
                    ->from($fromAddress, $appName)
                    ->subject("Queued Test Mail - {$appName}");
        });

        Log::info("Queued test email delivered successfully to: {$recipient}");
    }

    /**
     * Handle job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error("SendTestEmailJob failed for recipient {$this->recipient}: " . $exception->getMessage(), [
            'trace' => $exception->getTraceAsString(),
        ]);
    }
}
