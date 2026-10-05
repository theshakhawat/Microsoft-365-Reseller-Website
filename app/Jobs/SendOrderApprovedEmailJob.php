<?php

namespace App\Jobs;

use App\Models\Order;
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

class SendOrderApprovedEmailJob implements ShouldQueue
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
     * The approved order instance
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
            Log::warning("SendOrderApprovedEmailJob: Order not found.");
            return;
        }

        $user = $order->user;
        $recipientEmail = $order->recipient_email ?: ($user ? $user->email : null);

        if (!$recipientEmail) {
            Log::warning("SendOrderApprovedEmailJob: No recipient email found for Order #{$order->order_number}");
            return;
        }

        $recipientName = $order->recipient_name ?: ($user ? $user->name : 'Valued Customer');
        $appName = site_setting('site_name', config('app.name', 'Microsoft Office Club'));
        $fromAddress = config('mail.from.address', 'support@microsoftoffice.club');

        try {
            $htmlContent = view('emails.order-approved', compact('order'))->render();

            Mail::html($htmlContent, function ($message) use ($recipientEmail, $recipientName, $appName, $fromAddress, $order) {
                $message->to($recipientEmail, $recipientName)
                        ->from($fromAddress, $appName)
                        ->subject("Order Approved & Subscription Activated - #{$order->order_number} | {$appName}");
            });

            Log::info("Order approved email queued/sent successfully for Order #{$order->order_number} to {$recipientEmail}");
        } catch (\Throwable $e) {
            Log::error("Failed to send order approved email for Order #{$order->order_number} to {$recipientEmail}: " . $e->getMessage());
            throw $e;
        }
    }
}
