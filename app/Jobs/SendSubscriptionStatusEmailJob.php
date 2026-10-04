<?php

namespace App\Jobs;

use App\Models\SiteSetting;
use App\Models\SmtpSetting;
use App\Models\Subscription;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendSubscriptionStatusEmailJob implements ShouldQueue
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
     * Subscription instance
     */
    public Subscription $subscription;

    /**
     * Target status (suspended, expired, inactive, active)
     */
    public string $status;

    /**
     * Optional admin note or reason
     */
    public ?string $reason;

    /**
     * Create a new job instance.
     */
    public function __construct(Subscription $subscription, string $status, ?string $reason = null)
    {
        $this->subscription = $subscription;
        $this->status = strtolower($status);
        $this->reason = $reason;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Apply fresh database SMTP configuration
        SmtpSetting::applyConfig();

        $subscription = $this->subscription->fresh(['user', 'pricingPlan']);
        if (!$subscription) {
            Log::warning("SendSubscriptionStatusEmailJob: Subscription not found.");
            return;
        }

        $user = $subscription->user;
        $recipientEmail = $subscription->license_email ?: ($user ? $user->email : null);

        if (!$recipientEmail) {
            Log::warning("SendSubscriptionStatusEmailJob: No email for subscription ID {$subscription->id}");
            return;
        }

        $recipientName = $user ? $user->name : 'Valued Customer';
        $appName = site_setting('site_name', config('app.name', 'Microsoft Office Club'));
        $fromAddress = config('mail.from.address', 'support@microsoftoffice.club');
        $supportEmail = site_setting('contact_email', 'support@cloudsync.com.bd');
        $supportPhone = site_setting('contact_phone', '09649-0123756');
        $whatsappNumber = site_setting('whatsapp_number', '+880 1342-325558');
        $whatsappRaw = site_setting('whatsapp_raw_number', '8801342325558');
        $subscriptionsUrl = route('user.subscriptions');
        $renewUrl = route('user.plans');

        $statusConfig = match ($this->status) {
            'suspended' => [
                'subject'    => "Subscription Suspended - {$subscription->plan_name} | {$appName}",
                'badge'      => '⚠️ Subscription Suspended',
                'badge_bg'   => 'rgba(239, 68, 68, 0.2)',
                'badge_border' => '#ef4444',
                'badge_color' => '#fca5a5',
                'title'      => 'Your Subscription Has Been Suspended',
                'desc'       => 'Your Microsoft 365 cloud subscription has been temporarily suspended by system administrators.',
                'btn_text'   => 'Contact Support to Reactivate',
                'btn_url'    => route('user.tickets.create'),
            ],
            'expired' => [
                'subject'    => "Subscription Expired - {$subscription->plan_name} | {$appName}",
                'badge'      => '⏳ Subscription Expired',
                'badge_bg'   => 'rgba(245, 158, 11, 0.2)',
                'badge_border' => '#f59e0b',
                'badge_color' => '#fcd34d',
                'title'      => 'Your Subscription Has Expired',
                'desc'       => 'The validity period for your Microsoft 365 subscription has ended. Renew now to avoid losing access to your cloud storage and apps.',
                'btn_text'   => 'Renew Subscription Now',
                'btn_url'    => $renewUrl,
            ],
            'inactive', 'cancelled' => [
                'subject'    => "Subscription Deactivated - {$subscription->plan_name} | {$appName}",
                'badge'      => '🚫 Subscription Inactive',
                'badge_bg'   => 'rgba(100, 116, 139, 0.2)',
                'badge_border' => '#64748b',
                'badge_color' => '#cbd5e1',
                'title'      => 'Your Subscription is Deactivated',
                'desc'       => 'Your Microsoft 365 subscription is currently marked as inactive.',
                'btn_text'   => 'View Available Plans',
                'btn_url'    => $renewUrl,
            ],
            default => [
                'subject'    => "Subscription Status Updated - {$subscription->plan_name} | {$appName}",
                'badge'      => '✓ Subscription Active',
                'badge_bg'   => 'rgba(16, 185, 129, 0.2)',
                'badge_border' => '#10b981',
                'badge_color' => '#a7f3d0',
                'title'      => 'Your Subscription is Active',
                'desc'       => 'Your Microsoft 365 license status is currently active and ready to use.',
                'btn_text'   => 'Go to Subscriptions',
                'btn_url'    => $subscriptionsUrl,
            ],
        };

        $validUntil = $subscription->expires_at ? $subscription->expires_at->format('M d, Y') : 'N/A';
        $cloudStorage = $subscription->cloud_storage ?: '1 TB OneDrive Cloud Storage';
        $licenseKey = $subscription->subscription_key ?: 'M365-ACTIVE';
        $reasonNote = $this->reason ?: ($subscription->admin_notes ? trim($subscription->admin_notes) : null);

        $htmlContent = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>{$statusConfig['subject']}</title>
        </head>
        <body style='margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif;'>
            <table role='presentation' width='100%' cellspacing='0' cellpadding='0' style='background-color: #f1f5f9; padding: 30px 15px;'>
                <tr>
                    <td align='center'>
                        <table role='presentation' width='100%' max-width='600' style='max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;'>
                            
                            <!-- Header Banner (Microsoft Blue Gradient) -->
                            <tr>
                                <td style='background: linear-gradient(135deg, #0b192c 0%, #0067b8 100%); padding: 36px 30px; text-align: center;'>
                                    <div style='display: inline-block; margin-bottom: 12px;'>
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
                                    <div style='display: inline-block; background-color: {$statusConfig['badge_bg']}; border: 1px solid {$statusConfig['badge_border']}; color: {$statusConfig['badge_color']}; padding: 4px 14px; border-radius: 9999px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;'>
                                        {$statusConfig['badge']}
                                    </div>
                                    <h1 style='color: #ffffff; font-size: 22px; font-weight: 800; margin: 4px 0 0 0; letter-spacing: -0.5px;'>
                                        {$statusConfig['title']}
                                    </h1>
                                    <p style='color: #bae0fd; font-size: 13px; margin: 6px 0 0 0;'>
                                        " . e($subscription->plan_name) . "
                                    </p>
                                </td>
                            </tr>

                            <!-- Body Content -->
                            <tr>
                                <td style='padding: 32px 30px;'>
                                    <p style='color: #1e293b; font-size: 15px; font-weight: bold; margin: 0 0 10px 0;'>
                                        Hello " . e($recipientName) . ",
                                    </p>
                                    <p style='color: #475569; font-size: 14px; line-height: 1.6; margin: 0 0 20px 0;'>
                                        {$statusConfig['desc']}
                                    </p>

                                    " . ($reasonNote ? "
                                    <!-- Note / Reason Alert Box -->
                                    <div style='background-color: #fffbeb; border-left: 4px solid #f59e0b; padding: 14px 18px; border-radius: 0 8px 8px 0; margin-bottom: 22px; font-size: 13px; color: #92400e; line-height: 1.5;'>
                                        <strong>Admin Notice:</strong> " . e($reasonNote) . "
                                    </div>
                                    " : "") . "

                                    <!-- Subscription Details Card -->
                                    <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 24px;'>
                                        <h3 style='color: #0067b8; font-size: 12px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 14px 0;'>
                                            Subscription Summary
                                        </h3>
                                        <table role='presentation' width='100%' style='font-size: 13px; border-collapse: collapse;'>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b;'>Plan Name:</td>
                                                <td style='padding: 8px 0; color: #1e293b; font-weight: bold; text-align: right;'>" . e($subscription->plan_name) . "</td>
                                            </tr>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b;'>Licensed Email:</td>
                                                <td style='padding: 8px 0; color: #1e293b; font-weight: 600; text-align: right;'>" . e($subscription->license_email) . "</td>
                                            </tr>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b;'>License Key:</td>
                                                <td style='padding: 8px 0; color: #1e293b; font-family: monospace; font-weight: bold; text-align: right;'>" . e($licenseKey) . "</td>
                                            </tr>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b;'>Cloud Storage:</td>
                                                <td style='padding: 8px 0; color: #1e293b; font-weight: 600; text-align: right;'>" . e($cloudStorage) . "</td>
                                            </tr>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b;'>Expiry Date:</td>
                                                <td style='padding: 8px 0; color: #1e293b; font-weight: bold; text-align: right;'>{$validUntil}</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 8px 0; color: #64748b;'>Current Status:</td>
                                                <td style='padding: 8px 0; font-weight: 800; text-align: right; text-transform: uppercase;'>
                                                    " . strtoupper($this->status) . "
                                                </td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Main CTA Button -->
                                    <div style='text-align: center; margin: 28px 0;'>
                                        <a href='{$statusConfig['btn_url']}' style='background-color: #0067b8; color: #ffffff; padding: 14px 32px; border-radius: 10px; font-weight: bold; font-size: 14px; text-decoration: none; display: inline-block; box-shadow: 0 4px 12px rgba(0, 103, 184, 0.35);'>
                                            {$statusConfig['btn_text']} &rarr;
                                        </a>
                                    </div>

                                    <!-- Customer Support Help Box -->
                                    <div style='border-top: 1px solid #e2e8f0; padding-top: 20px; font-size: 12px; color: #64748b; line-height: 1.5;'>
                                        <p style='margin: 0 0 6px 0; font-weight: bold; color: #334155;'>Questions or need assistance?</p>
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
                                    <p style='margin: 0; color: #64748b;'>You received this email regarding your Microsoft 365 cloud subscription status.</p>
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
            Mail::html($htmlContent, function ($message) use ($recipientEmail, $recipientName, $appName, $fromAddress, $statusConfig) {
                $message->to($recipientEmail, $recipientName)
                        ->from($fromAddress, $appName)
                        ->subject($statusConfig['subject']);
            });

            Log::info("Subscription status ({$this->status}) email sent successfully for ID {$subscription->id} to {$recipientEmail}");
        } catch (\Throwable $e) {
            Log::error("Failed to send subscription status ({$this->status}) email for ID {$subscription->id} to {$recipientEmail}: " . $e->getMessage());
            throw $e;
        }
    }
}
