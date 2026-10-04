<?php

namespace App\Jobs;

use App\Models\Order;
use App\Models\SiteSetting;
use App\Models\SmtpSetting;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendOrderCancelledEmailJob implements ShouldQueue
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
     * Order instance
     */
    public Order $order;

    /**
     * Optional reason note
     */
    public ?string $reason;

    /**
     * Create a new job instance.
     */
    public function __construct(Order $order, ?string $reason = null)
    {
        $this->order = $order;
        $this->reason = $reason;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Apply fresh database SMTP configuration
        SmtpSetting::applyConfig();

        $order = $this->order->fresh(['user', 'pricingPlan']);
        if (!$order) {
            Log::warning("SendOrderCancelledEmailJob: Order not found.");
            return;
        }

        $user = $order->user;
        $recipientEmail = $order->recipient_email ?: ($user ? $user->email : null);

        if (!$recipientEmail) {
            Log::warning("SendOrderCancelledEmailJob: No email for order #{$order->order_number}");
            return;
        }

        $recipientName = $order->recipient_name ?: ($user ? $user->name : 'Valued Customer');
        $appName = site_setting('site_name', config('app.name', 'Microsoft Office Club'));
        $fromAddress = config('mail.from.address', 'support@microsoftoffice.club');
        $supportEmail = site_setting('contact_email', 'support@cloudsync.com.bd');
        $supportPhone = site_setting('contact_phone', '09649-0123756');
        $whatsappNumber = site_setting('whatsapp_number', '+880 1342-325558');
        $whatsappRaw = site_setting('whatsapp_raw_number', '8801342325558');
        $plansUrl = route('user.plans');
        $ordersUrl = route('user.orders');

        $reasonText = $this->reason ?: ($order->notes ? trim($order->notes) : 'Payment verification could not be completed or order was cancelled by administrator.');

        $htmlContent = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='UTF-8'>
            <meta name='viewport' content='width=device-width, initial-scale=1.0'>
            <title>Order Cancelled - #{$order->order_number}</title>
        </head>
        <body style='margin: 0; padding: 0; background-color: #f1f5f9; font-family: -apple-system, BlinkMacSystemFont, Segoe UI, Roboto, Helvetica, Arial, sans-serif;'>
            <table role='presentation' width='100%' cellspacing='0' cellpadding='0' style='background-color: #f1f5f9; padding: 30px 15px;'>
                <tr>
                    <td align='center'>
                        <table role='presentation' width='100%' max-width='600' style='max-width: 600px; background-color: #ffffff; border-radius: 16px; overflow: hidden; box-shadow: 0 10px 25px -5px rgba(0,0,0,0.06); border: 1px solid #e2e8f0;'>
                            
                            <!-- Header Banner (Microsoft Blue/Dark Gradient) -->
                            <tr>
                                <td style='background: linear-gradient(135deg, #1e1b4b 0%, #1e293b 100%); padding: 36px 30px; text-align: center;'>
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
                                    <div style='display: inline-block; background-color: rgba(239, 68, 68, 0.2); border: 1px solid #ef4444; color: #fca5a5; padding: 4px 14px; border-radius: 9999px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 8px;'>
                                        ✕ Order Cancelled
                                    </div>
                                    <h1 style='color: #ffffff; font-size: 22px; font-weight: 800; margin: 4px 0 0 0; letter-spacing: -0.5px;'>
                                        Order #{$order->order_number} Cancelled
                                    </h1>
                                    <p style='color: #cbd5e1; font-size: 13px; margin: 6px 0 0 0;'>
                                        " . e($order->plan_name) . "
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
                                        Your order <strong>#{$order->order_number}</strong> for <strong>" . e($order->plan_name) . "</strong> has been cancelled.
                                    </p>

                                    <!-- Reason Box -->
                                    <div style='background-color: #fef2f2; border-left: 4px solid #ef4444; padding: 14px 18px; border-radius: 0 8px 8px 0; margin-bottom: 22px; font-size: 13px; color: #991b1b; line-height: 1.5;'>
                                        <strong>Cancellation Notice:</strong> " . e($reasonText) . "
                                    </div>

                                    <!-- Order Summary Table -->
                                    <div style='background-color: #f8fafc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 20px; margin-bottom: 24px;'>
                                        <table role='presentation' width='100%' style='font-size: 13px; border-collapse: collapse;'>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b;'>Order Number:</td>
                                                <td style='padding: 8px 0; color: #1e293b; font-weight: bold; text-align: right;'>#{$order->order_number}</td>
                                            </tr>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b;'>Plan Name:</td>
                                                <td style='padding: 8px 0; color: #1e293b; font-weight: 600; text-align: right;'>" . e($order->plan_name) . "</td>
                                            </tr>
                                            <tr style='border-bottom: 1px solid #f1f5f9;'>
                                                <td style='padding: 8px 0; color: #64748b;'>Amount:</td>
                                                <td style='padding: 8px 0; color: #1e293b; font-weight: 700; text-align: right;'>৳ " . number_format($order->payable_amount, 2) . "</td>
                                            </tr>
                                            <tr>
                                                <td style='padding: 8px 0; color: #64748b;'>Status:</td>
                                                <td style='padding: 8px 0; color: #ef4444; font-weight: 800; text-align: right;'>CANCELLED</td>
                                            </tr>
                                        </table>
                                    </div>

                                    <!-- Action Buttons -->
                                    <table role='presentation' width='100%' cellspacing='0' cellpadding='0' style='margin: 26px 0;'>
                                        <tr>
                                            <td align='center' style='padding: 6px;'>
                                                <a href='{$plansUrl}' style='background-color: #0067b8; color: #ffffff; padding: 13px 24px; border-radius: 8px; font-weight: bold; font-size: 13px; text-decoration: none; display: inline-block;'>
                                                    Re-order Plan &rarr;
                                                </a>
                                            </td>
                                            <td align='center' style='padding: 6px;'>
                                                <a href='{$ordersUrl}' style='background-color: #f1f5f9; color: #334155; border: 1px solid #cbd5e1; padding: 13px 20px; border-radius: 8px; font-weight: bold; font-size: 13px; text-decoration: none; display: inline-block;'>
                                                    View My Orders
                                                </a>
                                            </td>
                                        </tr>
                                    </table>

                                    <!-- Help Info -->
                                    <div style='border-top: 1px solid #e2e8f0; padding-top: 20px; font-size: 12px; color: #64748b; line-height: 1.5;'>
                                        <p style='margin: 0 0 6px 0; font-weight: bold; color: #334155;'>Believe this is an error or already paid?</p>
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
                                    <p style='margin: 0; color: #64748b;'>You received this email regarding your purchase order on {$appName}.</p>
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
                        ->subject("Order Cancelled - #{$order->order_number} | {$appName}");
            });

            Log::info("Order cancellation email sent for #{$order->order_number} to {$recipientEmail}");
        } catch (\Throwable $e) {
            Log::error("Failed to send order cancellation email for #{$order->order_number}: " . $e->getMessage());
            throw $e;
        }
    }
}
