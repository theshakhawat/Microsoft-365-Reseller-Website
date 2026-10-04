<?php

namespace App\Jobs;

use App\Models\AppNotification;
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

class SendWelcomeEmailJob implements ShouldQueue
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
     * The registered user
     */
    public User $user;

    /**
     * Create a new job instance.
     */
    public function __construct(User $user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Apply fresh database SMTP configuration
        SmtpSetting::applyConfig();

        $user = $this->user;
        $appName = site_setting('site_name', config('app.name', 'Microsoft Office Club'));
        $fromAddress = config('mail.from.address', 'support@microsoftoffice.club');
        $siteUrl = url('/');
        $dashboardUrl = route('user.dashboard');
        $supportEmail = site_setting('contact_email', 'support@cloudsync.com.bd');
        $supportPhone = site_setting('contact_phone', '09649-0123756');
        $whatsappNumber = site_setting('whatsapp_number', '+880 1342-325558');
        $whatsappRaw = site_setting('whatsapp_raw_number', '8801342325558');
        $logoUrl = site_file_url('header_logo', 'assets/img/Microsoft Office Club Logo.png');

        $htmlContent = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Welcome to {$appName}</title>
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
                                    <h1 style='color: #ffffff; font-size: 24px; font-weight: 800; margin: 0; letter-spacing: -0.5px;'>Welcome to {$appName}!</h1>
                                    <p style='color: #bae0fd; font-size: 13px; margin: 6px 0 0 0;'>Official Microsoft 365 Cloud Subscription & Licensing Provider</p>
                                </td>
                            </tr>

                            <!-- Body Content -->
                            <tr>
                                <td style='padding: 32px 30px;'>
                                    <p style='color: #1e293b; font-size: 16px; font-weight: bold; margin: 0 0 12px 0;'>Hello " . e($user->name) . ",</p>
                                    <p style='color: #475569; font-size: 14px; line-height: 1.6; margin: 0 0 24px 0;'>
                                        Thank you for creating an account with <strong>{$appName}</strong>. Your registration is complete, and your account is now ready for instant cloud subscriptions, automated license activations, and premium support.
                                    </p>

                                    <!-- Account Summary Card -->
                                    <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 26px;'>
                                        <h3 style='color: #0067b8; font-size: 13px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 14px 0;'>
                                            Your Account Details
                                        </h3>
                                        <table role='presentation' width='100%' style='font-size: 13px; border-collapse: collapse;'>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b; font-weight: 600;'>Full Name:</td>
                                                <td style='padding: 8px 0; color: #1e293b; font-weight: bold; text-align: right;'>" . e($user->name) . "</td>
                                            </tr>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b; font-weight: 600;'>Registered Email:</td>
                                                <td style='padding: 8px 0; color: #1e293b; font-weight: bold; text-align: right;'>" . e($user->email) . "</td>
                                            </tr>
                                            " . ($user->phone ? "
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b; font-weight: 600;'>Phone Number:</td>
                                                <td style='padding: 8px 0; color: #1e293b; font-weight: bold; text-align: right;'>" . e($user->phone) . "</td>
                                            </tr>
                                            " : "") . "
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b; font-weight: 600;'>Account Status:</td>
                                                <td style='padding: 8px 0; color: #16a34a; font-weight: bold; text-align: right;'>Active & Verified</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 8px 0; color: #64748b; font-weight: 600;'>Joined Date:</td>
                                                <td style='padding: 8px 0; color: #1e293b; font-weight: bold; text-align: right;'>" . now()->format('M d, Y - h:i A') . "</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Main CTA Button -->
                                    <div style='text-align: center; margin: 30px 0;'>
                                        <a href='{$dashboardUrl}' style='background-color: #0067b8; color: #ffffff; padding: 14px 32px; border-radius: 10px; font-weight: bold; font-size: 14px; text-decoration: none; display: inline-block; box-shadow: 0 4px 12px rgba(0, 103, 184, 0.35);'>
                                            Go to Your Dashboard &rarr;
                                        </a>
                                    </div>

                                    <!-- Benefits Highlights Box -->
                                    <div style='background-color: #f0f9ff; border: 1px solid #bae6fd; border-radius: 12px; padding: 18px; margin-bottom: 26px;'>
                                        <h4 style='color: #0369a1; font-size: 13px; font-weight: bold; margin: 0 0 10px 0;'>What you can do next:</h4>
                                        <ul style='color: #334155; font-size: 13px; margin: 0; padding-left: 20px; line-height: 1.6;'>
                                            <li>Browse genuine Microsoft 365 Personal, Family, and Business plans.</li>
                                            <li>Pay instantly in BDT with local bKash, Nagad & Cards without foreign exchange fees.</li>
                                            <li>Get automated 1TB OneDrive cloud storage & Copilot AI integration.</li>
                                            <li>Submit priority support tickets anytime you need assistance.</li>
                                        </ul>
                                    </div>

                                    <!-- Customer Support Help Box -->
                                    <div style='border-top: 1px solid #e2e8f0; padding-top: 20px; font-size: 12px; color: #64748b; line-height: 1.5;'>
                                        <p style='margin: 0 0 6px 0; font-weight: bold; color: #334155;'>Need help or have questions?</p>
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
                                    <p style='margin: 0; color: #64748b;'>You received this email because you signed up on our platform.</p>
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
                        ->subject("Welcome to {$appName}! Your account is ready");
            });

            Log::info("Welcome email successfully sent to registered user: {$user->email}");
        } catch (\Throwable $e) {
            Log::error("Failed to send welcome email to user {$user->email}: " . $e->getMessage());
            throw $e;
        }

        // Also create in-app welcoming notification
        try {
            AppNotification::create([
                'user_id' => $user->id,
                'target_role' => 'user',
                'title' => 'Welcome to ' . $appName . '!',
                'message' => 'Your account has been created successfully. Explore our plans and start enjoying genuine Microsoft 365 cloud licensing.',
                'type' => 'success',
                'icon' => 'fa-solid fa-user-check',
                'action_url' => route('user.dashboard'),
                'is_read' => false,
            ]);
        } catch (\Throwable $e) {
            Log::warning("Could not create in-app welcome notification: " . $e->getMessage());
        }
    }
}
