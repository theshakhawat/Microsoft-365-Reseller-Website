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
        $subscription = Subscription::where('order_id', $order->id)->first() 
            ?? Subscription::where('user_id', $order->user_id)->latest()->first();

        $appName = site_setting('site_name', config('app.name', 'Microsoft Office Club'));
        $fromAddress = config('mail.from.address', 'support@microsoftoffice.club');
        $dashboardUrl = route('user.dashboard');
        $subscriptionsUrl = route('user.subscriptions');
        $invoiceUrl = route('user.invoice', $order->id);
        $supportEmail = site_setting('contact_email', 'support@cloudsync.com.bd');
        $supportPhone = site_setting('contact_phone', '09649-0123756');
        $whatsappNumber = site_setting('whatsapp_number', '+880 1342-325558');
        $whatsappRaw = site_setting('whatsapp_raw_number', '8801342325558');

        $licenseKey = $subscription ? $subscription->subscription_key : 'PROVISIONED-ACTIVE';
        $licenseEmail = $subscription ? $subscription->license_email : $recipientEmail;
        $validUntil = ($subscription && $subscription->expires_at) 
            ? $subscription->expires_at->format('M d, Y') 
            : now()->addYear()->format('M d, Y');
        $cloudStorage = ($subscription && $subscription->cloud_storage) ? $subscription->cloud_storage : '1 TB OneDrive Cloud Storage';
        $paymentMethodName = $order->paymentMethod ? $order->paymentMethod->name : strtoupper($order->payment_method_slug ?? 'Online');
        $formattedPrice = '৳ ' . number_format($order->payable_amount, 2);

        $htmlContent = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Order Approved - {$appName}</title>
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
                                    <div style='display: inline-block; background-color: rgba(16, 185, 129, 0.2); border: 1px solid #10b981; color: #a7f3d0; padding: 4px 12px; border-radius: 9999px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;'>
                                        ✓ Payment Verified & Approved
                                    </div>
                                    <h1 style='color: #ffffff; font-size: 24px; font-weight: 800; margin: 4px 0 0 0; letter-spacing: -0.5px;'>
                                        Your Order is Approved! 🎉
                                    </h1>
                                    <p style='color: #bae0fd; font-size: 13px; margin: 6px 0 0 0;'>
                                        Microsoft 365 License has been activated for your account
                                    </p>
                                </td>
                            </tr>

                            <!-- Body Content -->
                            <tr>
                                <td style='padding: 32px 30px;'>
                                    <p style='color: #1e293b; font-size: 16px; font-weight: bold; margin: 0 0 10px 0;'>
                                        Dear " . e($recipientName) . ",
                                    </p>
                                    <p style='color: #475569; font-size: 14px; line-height: 1.6; margin: 0 0 22px 0;'>
                                        Great news! Your purchase order <strong>#" . e($order->order_number) . "</strong> for <strong>" . e($order->plan_name) . "</strong> has been verified and approved by our team. Your genuine Microsoft 365 cloud license is now active and ready for immediate use.
                                    </p>

                                    <!-- License Details Activation Box -->
                                    <div style='background: linear-gradient(135deg, #0b192c 0%, #1e293b 100%); color: #ffffff; border-radius: 12px; padding: 22px; margin-bottom: 24px; box-shadow: 0 4px 12px rgba(11, 25, 44, 0.15);'>
                                        <div style='font-size: 11px; text-transform: uppercase; color: #38bdf8; font-weight: 700; letter-spacing: 1px; margin-bottom: 6px;'>
                                            🔑 Provisioned License Key
                                        </div>
                                        <div style='font-size: 18px; font-family: monospace; font-weight: 800; color: #ffffff; letter-spacing: 1px; background: rgba(255,255,255,0.08); padding: 10px 14px; border-radius: 8px; border: 1px dashed rgba(255,255,255,0.25); word-break: break-all; margin-bottom: 14px;'>
                                            " . e($licenseKey) . "
                                        </div>
                                        <table role='presentation' width='100%' style='font-size: 12px; color: #cbd5e1; border-collapse: collapse;'>
                                            <tr>
                                                <td style='padding: 4px 0;'>Licensed Email:</td>
                                                <td style='padding: 4px 0; text-align: right; color: #ffffff; font-weight: bold;'>" . e($licenseEmail) . "</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 4px 0;'>Plan Package:</td>
                                                <td style='padding: 4px 0; text-align: right; color: #38bdf8; font-weight: bold;'>" . e($order->plan_name) . "</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 4px 0;'>Cloud Storage:</td>
                                                <td style='padding: 4px 0; text-align: right; color: #a7f3d0; font-weight: bold;'>" . e($cloudStorage) . "</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 4px 0;'>Validity Until:</td>
                                                <td style='padding: 4px 0; text-align: right; color: #fbbf24; font-weight: bold;'>" . e($validUntil) . "</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Order Summary Table -->
                                    <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 24px;'>
                                        <h3 style='color: #0067b8; font-size: 13px; font-weight: bold; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 14px 0;'>
                                            Order & Payment Receipt
                                        </h3>
                                        <table role='presentation' width='100%' style='font-size: 13px; border-collapse: collapse;'>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 7px 0; color: #64748b;'>Order Number:</td>
                                                <td style='padding: 7px 0; color: #1e293b; font-weight: bold; text-align: right;'>#" . e($order->order_number) . "</td>
                                            </tr>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 7px 0; color: #64748b;'>Payment Method:</td>
                                                <td style='padding: 7px 0; color: #1e293b; font-weight: 600; text-align: right;'>" . e($paymentMethodName) . "</td>
                                            </tr>
                                            " . ($order->gateway_txn_id ? "
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 7px 0; color: #64748b;'>Transaction ID / TrxID:</td>
                                                <td style='padding: 7px 0; color: #1e293b; font-family: monospace; font-weight: bold; text-align: right;'>" . e($order->gateway_txn_id) . "</td>
                                            </tr>
                                            " : "") . "
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 7px 0; color: #64748b;'>Amount Paid:</td>
                                                <td style='padding: 7px 0; color: #0067b8; font-weight: 800; font-size: 15px; text-align: right;'>" . e($formattedPrice) . "</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 7px 0; color: #64748b;'>Payment Status:</td>
                                                <td style='padding: 7px 0; color: #16a34a; font-weight: bold; text-align: right;'>PAID & CONFIRMED</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Action Buttons -->
                                    <table role='presentation' width='100%' cellspacing='0' cellpadding='0' style='margin: 26px 0;'>
                                        <tr>
                                            <td align='center' style='padding: 6px;'>
                                                <a href='{$subscriptionsUrl}' style='background-color: #0067b8; color: #ffffff; padding: 13px 24px; border-radius: 8px; font-weight: bold; font-size: 13px; text-decoration: none; display: inline-block; box-shadow: 0 4px 12px rgba(0, 103, 184, 0.35);'>
                                                    View My Subscription &rarr;
                                                </a>
                                            </td>
                                            <td align='center' style='padding: 6px;'>
                                                <a href='{$invoiceUrl}' style='background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; padding: 13px 20px; border-radius: 8px; font-weight: bold; font-size: 13px; text-decoration: none; display: inline-block;'>
                                                    📄 Download Invoice
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- Activation Steps Guide -->
                                    <div style='background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 12px; padding: 18px; margin-bottom: 24px;'>
                                        <h4 style='color: #166534; font-size: 13px; font-weight: bold; margin: 0 0 10px 0;'>
                                            How to log in to your Microsoft Account:
                                        </h4>
                                        <ol style='color: #374151; font-size: 13px; margin: 0; padding-left: 20px; line-height: 1.6;'>
                                            <li>Visit <a href='https://portal.office.com' target='_blank' style='color: #0067b8; font-weight: 600; text-decoration: none;'>portal.office.com</a> or <a href='https://onedrive.live.com' target='_blank' style='color: #0067b8; font-weight: 600; text-decoration: none;'>onedrive.live.com</a>.</li>
                                            <li>Sign in using your authorized email (<strong>" . e($licenseEmail) . "</strong>).</li>
                                            <li>Download and install Desktop & Mobile apps (Word, Excel, PowerPoint, Outlook, OneDrive).</li>
                                            <li>Enjoy full 1 TB cloud storage and Copilot AI productivity tools!</li>
                                        </ol>
                                    </div>

                                    <!-- Customer Support Help Box -->
                                    <div style='border-top: 1px solid #e2e8f0; padding-top: 20px; font-size: 12px; color: #64748b; line-height: 1.5;'>
                                        <p style='margin: 0 0 6px 0; font-weight: bold; color: #334155;'>Questions or need assistance setting up?</p>
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
                                    <p style='margin: 0; color: #64748b;'>You received this email because you placed an order on {$appName}.</p>
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
