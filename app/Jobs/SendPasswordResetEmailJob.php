<?php

namespace App\Jobs;

use App\Models\SiteSetting;
use App\Models\SmtpSetting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendPasswordResetEmailJob implements ShouldQueue
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
     * The User instance
     */
    public User $user;

    /**
     * Plain text password reset token
     */
    public string $token;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user, string $token)
    {
        $this->user = $user;
        $this->token = $token;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Apply fresh database SMTP configuration
        SmtpSetting::applyConfig();

        $user = $this->user;
        $token = $this->token;
        $appName = site_setting('site_name', config('app.name', 'Microsoft Office Club'));
        $fromAddress = config('mail.from.address', 'support@microsoftoffice.club');
        $resetUrl = route('password.reset', ['token' => $token, 'email' => $user->email]);
        $supportEmail = site_setting('contact_email', 'support@cloudsync.com.bd');
        $supportPhone = site_setting('contact_phone', '09649-0123756');
        $whatsappNumber = site_setting('whatsapp_number', '+880 1342-325558');
        $whatsappRaw = site_setting('whatsapp_raw_number', '8801342325558');

        $htmlContent = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Reset Password - {$appName}</title>
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
                                    <div style='display: inline-block; background-color: rgba(255, 255, 255, 0.15); border: 1px solid rgba(255, 255, 255, 0.3); color: #ffffff; padding: 4px 12px; border-radius: 9999px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;'>
                                        🔒 Security Alert
                                    </div>
                                    <h1 style='color: #ffffff; font-size: 24px; font-weight: 800; margin: 4px 0 0 0; letter-spacing: -0.5px;'>
                                        Reset Your Password
                                    </h1>
                                    <p style='color: #bae0fd; font-size: 13px; margin: 6px 0 0 0;'>
                                        Account Security & Recovery Request
                                    </p>
                                </td>
                            </tr>

                            <!-- Body Content -->
                            <tr>
                                <td style='padding: 32px 30px;'>
                                    <p style='color: #1e293b; font-size: 16px; font-weight: bold; margin: 0 0 12px 0;'>
                                        Hello " . e($user->name) . ",
                                    </p>
                                    <p style='color: #475569; font-size: 14px; line-height: 1.6; margin: 0 0 24px 0;'>
                                        You are receiving this email because we received a password reset request for your account on <strong>{$appName}</strong>. Click the button below to choose a new password.
                                    </p>

                                    <!-- Main CTA Button -->
                                    <div style='text-align: center; margin: 32px 0;'>
                                        <a href='{$resetUrl}' style='background-color: #0067b8; color: #ffffff; padding: 15px 36px; border-radius: 10px; font-weight: bold; font-size: 15px; text-decoration: none; display: inline-block; box-shadow: 0 4px 14px rgba(0, 103, 184, 0.4);'>
                                            Reset Password &rarr;
                                        </a>
                                    </div>

                                    <!-- Expiration Notice -->
                                    <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 16px; margin-bottom: 24px; font-size: 13px; color: #64748b; line-height: 1.5;'>
                                        <p style='margin: 0 0 6px 0;'>
                                            ⏱️ <strong>Note:</strong> This password reset link will expire in <strong>60 minutes</strong>.
                                        </p>
                                        <p style='margin: 0;'>
                                            If you did not request a password reset, please ignore this email. Your password will remain unchanged and your account is secure.
                                        </p>
                                    </div>

                                    <!-- Plain Link Fallback -->
                                    <div style='border-top: 1px solid #f1f5f9; padding-top: 16px; margin-bottom: 20px; font-size: 12px; color: #94a3b8; word-break: break-all;'>
                                        <p style='margin: 0 0 4px 0;'>If you're having trouble clicking the \"Reset Password\" button, copy and paste the URL below into your web browser:</p>
                                        <a href='{$resetUrl}' style='color: #0067b8; text-decoration: underline;'>{$resetUrl}</a>
                                    </div>

                                    <!-- Customer Support Help Box -->
                                    <div style='border-top: 1px solid #e2e8f0; padding-top: 20px; font-size: 12px; color: #64748b; line-height: 1.5;'>
                                        <p style='margin: 0 0 6px 0; font-weight: bold; color: #334155;'>Need help with your account?</p>
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
                                    <p style='margin: 0; color: #64748b;'>You received this email because a password reset request was initiated for your email address.</p>
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
            Mail::html($htmlContent, function ($message) use ($user, $appName, $fromAddress) {
                $message->to($user->email, $user->name)
                        ->from($fromAddress, $appName)
                        ->subject("Reset Your Password - {$appName}");
            });

            Log::info("Password reset email sent successfully to: {$user->email}");
        } catch (\Throwable $e) {
            Log::error("Failed to send password reset email to {$user->email}: " . $e->getMessage());
            throw $e;
        }
    }
}
