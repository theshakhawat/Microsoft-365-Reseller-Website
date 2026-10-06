<?php

namespace App\Jobs;

use App\Models\Order;
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

class SendAdminNewOrderAlertJob implements ShouldQueue
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
     * The order instance
     */
    public Order $order;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Apply fresh database SMTP configuration
        SmtpSetting::applyConfig();

        $order = $this->order->fresh(['user', 'pricingPlan', 'paymentMethod']);
        if (!$order) {
            Log::warning("SendAdminNewOrderAlertJob: Order not found.");
            return;
        }

        $appName = site_setting('site_name', config('app.name', 'Microsoft Office Club'));
        $fromAddress = config('mail.from.address', 'support@microsoftoffice.club');

        // Resolve Admin Recipient Email
        $adminEmail = site_setting('admin_notification_email', site_setting('contact_email', User::where('role', 'admin')->value('email')));

        if (empty($adminEmail)) {
            Log::warning("SendAdminNewOrderAlertJob: No admin notification email configured.");
            return;
        }

        try {
            $htmlContent = view('emails.admin-new-order', compact('order'))->render();

            Mail::html($htmlContent, function ($message) use ($adminEmail, $appName, $fromAddress, $order) {
                $message->to($adminEmail)
                        ->from($fromAddress, $appName)
                        ->subject("[Action Required] New Paid Order #{$order->order_number} - {$appName}");
            });

            Log::info("Admin new order alert email sent to {$adminEmail} for Order #{$order->order_number}");
        } catch (\Throwable $e) {
            Log::error("Failed to send admin new order alert email for Order #{$order->order_number}: " . $e->getMessage());
            throw $e;
        }
    }
}
