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
     * The subscription model
     */
    public Subscription $subscription;

    /**
     * Status (active, suspended, expired, extended, etc.)
     */
    public string $status;

    /**
     * Optional custom admin notes
     */
    public ?string $notes;

    /**
     * Create a new job instance.
     */
    public function __construct(Subscription $subscription, string $status, ?string $notes = null)
    {
        $this->subscription = $subscription;
        $this->status = $status;
        $this->notes = $notes;
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
        if (!$user || empty($user->email)) {
            Log::warning("SendSubscriptionStatusEmailJob: User email not found for Subscription #{$subscription->id}");
            return;
        }

        $appName = site_setting('site_name', config('app.name', 'Microsoft Office Club'));
        $fromAddress = config('mail.from.address', 'support@microsoftoffice.club');
        $status = $this->status;
        $notes = $this->notes;

        $subject = match($status) {
            'active'    => "Subscription Activated & Ready - {$subscription->plan_name} | {$appName}",
            'suspended' => "Subscription Suspended - {$subscription->plan_name} | {$appName}",
            'expired'   => "Subscription Expired - {$subscription->plan_name} | {$appName}",
            'extended'  => "Subscription Validity Extended - {$subscription->plan_name} | {$appName}",
            default     => "Subscription Status Updated: " . ucfirst($status) . " - {$subscription->plan_name}",
        };

        try {
            $htmlContent = view('emails.subscription-status', compact('subscription', 'status', 'notes'))->render();

            Mail::html($htmlContent, function ($message) use ($user, $appName, $fromAddress, $subject) {
                $message->to($user->email, $user->name)
                        ->from($fromAddress, $appName)
                        ->subject($subject);
            });

            Log::info("Subscription status ({$status}) email sent successfully to {$user->email} for Subscription #{$subscription->id}");
        } catch (\Throwable $e) {
            Log::error("Failed to send subscription status email to {$user->email}: " . $e->getMessage());
            throw $e;
        }
    }
}
