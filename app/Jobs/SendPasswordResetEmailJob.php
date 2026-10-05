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
        $resetUrl = url(route('password.reset', [
            'token' => $token,
            'email' => $user->email,
        ], false));

        try {
            $htmlContent = view('emails.password-reset', compact('user', 'resetUrl', 'token'))->render();

            Mail::html($htmlContent, function ($message) use ($user, $appName, $fromAddress) {
                $message->to($user->email, $user->name)
                        ->from($fromAddress, $appName)
                        ->subject("Reset Your Password - {$appName}");
            });

            Log::info("Password reset email sent to {$user->email}");
        } catch (\Throwable $e) {
            Log::error("Failed to send password reset email to {$user->email}: " . $e->getMessage());
            throw $e;
        }
    }
}
