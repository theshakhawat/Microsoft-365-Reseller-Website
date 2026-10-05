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

        try {
            $htmlContent = view('emails.welcome', compact('user'))->render();

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

        // 2. Notify Admin via Email (if configured)
        try {
            $adminEmail = site_setting('admin_notification_email', site_setting('contact_email', User::where('role', 'admin')->value('email')));
            if (!empty($adminEmail)) {
                $adminHtml = "
                <!DOCTYPE html>
                <html>
                <head>
                    <meta charset='UTF-8'>
                    <title>New Customer Registered</title>
                </head>
                <body style='margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, sans-serif;'>
                    <table role='presentation' width='100%' cellspacing='0' cellpadding='0' style='background-color: #f1f5f9; padding: 30px 15px;'>
                        <tr>
                            <td align='center'>
                                <table role='presentation' width='100%' max-width='550' style='max-width: 550px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;'>
                                    <tr>
                                        <td style='background: linear-gradient(135deg, #0b192c 0%, #0067b8 100%); padding: 28px 24px; text-align: center; color: #ffffff;'>
                                            <h2 style='margin: 0; font-size: 20px; font-weight: 800;'>New Customer Registered</h2>
                                            <p style='margin: 4px 0 0 0; font-size: 12px; color: #bae0fd;'>{$appName} Admin Notification</p>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style='padding: 24px;'>
                                            <p style='font-size: 14px; color: #334155; margin: 0 0 16px 0;'>A new customer has created an account on your platform:</p>
                                            <table role='presentation' width='100%' style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 10px; padding: 14px; font-size: 13px;'>
                                                <tr>
                                                    <td style='padding: 6px 0; color: #64748b; font-weight: 600;'>Name:</td>
                                                    <td style='padding: 6px 0; font-weight: bold; color: #0f172a; text-align: right;'>" . e($user->name) . "</td>
                                                </tr>
                                                <tr>
                                                    <td style='padding: 6px 0; color: #64748b; font-weight: 600;'>Email:</td>
                                                    <td style='padding: 6px 0; font-weight: bold; color: #0067b8; text-align: right;'>" . e($user->email) . "</td>
                                                </tr>
                                                " . ($user->phone ? "
                                                <tr>
                                                    <td style='padding: 6px 0; color: #64748b; font-weight: 600;'>Phone:</td>
                                                    <td style='padding: 6px 0; font-weight: bold; color: #0f172a; text-align: right;'>" . e($user->phone) . "</td>
                                                </tr>
                                                " : "") . "
                                                <tr>
                                                    <td style='padding: 6px 0; color: #64748b; font-weight: 600;'>Joined:</td>
                                                    <td style='padding: 6px 0; font-weight: bold; color: #0f172a; text-align: right;'>" . now()->format('M d, Y - h:i A') . "</td>
                                                </tr>
                                            </table>
                                            <div style='text-align: center; margin-top: 24px;'>
                                                <a href='" . route('admin.users.edit', $user->id) . "' style='background-color: #0067b8; color: #ffffff; padding: 12px 24px; border-radius: 8px; font-weight: bold; font-size: 13px; text-decoration: none; display: inline-block;'>View Customer in Admin &rarr;</a>
                                            </div>
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
                    </table>
                </body>
                </html>
                ";

                Mail::html($adminHtml, function ($msg) use ($adminEmail, $appName, $fromAddress, $user) {
                    $msg->to($adminEmail)
                        ->from($fromAddress, $appName)
                        ->subject("[New Customer] {$user->name} ({$user->email}) registered on {$appName}");
                });
                Log::info("Admin registration notification email sent to {$adminEmail} for user {$user->email}");
            }
        } catch (\Throwable $e) {
            Log::warning("Could not send admin registration email: " . $e->getMessage());
        }

        // 3. Also create in-app welcoming notification for user
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
