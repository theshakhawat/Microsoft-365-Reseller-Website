<?php

namespace App\Http\Controllers\Payment;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class MoneybagPaymentController extends Controller
{
    /**
     * Get configured Moneybag PaymentMethod record
     */
    private function getMoneybagMethod(): ?PaymentMethod
    {
        return PaymentMethod::where('slug', 'moneybag')->first();
    }

    /**
     * Resolve API Endpoint dynamically from DB or config
     */
    private function getApiUrl(string $path, ?PaymentMethod $method = null): string
    {
        $method = $method ?: $this->getMoneybagMethod();
        $dbBase = $method?->base_url;

        $base = rtrim($dbBase ?: config('services.moneybag.base_url', 'https://api.moneybag.com.bd/api/v2'), '/');
        $cleanPath = ltrim($path, '/');

        // Normalize /api/v2 or /v2 duplicate paths
        if (str_ends_with($base, '/api/v2') && str_starts_with($cleanPath, 'api/v2/')) {
            $cleanPath = substr($cleanPath, 7);
        }

        return "{$base}/{$cleanPath}";
    }

    /**
     * Get Merchant API Key dynamically from DB or config
     */
    private function getMerchantKey(?PaymentMethod $method = null): ?string
    {
        $method = $method ?: $this->getMoneybagMethod();
        return $method?->merchant_key ?: config('services.moneybag.key');
    }

    /**
     * Initialize Checkout Request with Moneybag Payment Gateway
     */
    public function initiatePayment(Request $request): RedirectResponse
    {
        $orderNumber = $request->query('order_number') ?? $request->input('order_number');
        
        /** @var Order|null $order */
        $order = Order::where('order_number', $orderNumber)->where('user_id', Auth::id())->first();

        if (!$order) {
            return redirect()->route('user.plans')->with('error', 'Order not found or unauthorized access.');
        }

        if ($order->payment_status === 'paid') {
            return redirect()->route('user.orders')->with('success', 'Order #' . $order->order_number . ' is already paid.');
        }

        $amount = (float) $order->payable_amount;
        if ($amount <= 0) {
            $this->fulfillOrder($order, 'FREE-PROMO');
            return redirect()->route('user.orders')->with('success', 'Order #' . $order->order_number . ' completed successfully!');
        }

        $moneybagMethod = $this->getMoneybagMethod();
        $merchantKey = $this->getMerchantKey($moneybagMethod);

        if (empty($merchantKey)) {
            $order->update(['payment_status' => 'cancelled']);
            return redirect()->route('user.checkout', $order->pricing_plan_id)
                ->with('error', 'Moneybag payment gateway is not properly configured. Merchant key is missing.');
        }

        // Comprehensive payload conforming to Moneybag API v2 specs
        $payload = [
            'order_id'          => $order->order_number,
            'order_amount'      => round($amount, 2),
            'currency'          => 'BDT',
            'order_description' => 'Payment for ' . ($order->plan_name ?: 'Microsoft 365 License') . ' (#' . $order->order_number . ')',
            'success_url'       => route('user.payment.success', ['order_number' => $order->order_number]),
            'fail_url'          => route('user.payment.fail', ['order_number' => $order->order_number]),
            'cancel_url'        => route('user.payment.cancel', ['order_number' => $order->order_number]),
            'ipn_url'           => route('user.payment.ipn'),
            'customer'          => [
                'name'  => $order->recipient_name ?: Auth::user()->name,
                'email' => $order->recipient_email ?: Auth::user()->email,
                'phone' => $order->recipient_phone ?: (Auth::user()->phone ?? '01700000000'),
            ],
            'order_items'       => [
                [
                    'name'     => $order->plan_name ?: 'Microsoft 365 License',
                    'quantity' => 1,
                    'price'    => round($amount, 2),
                ]
            ],
            'metadata'          => [
                'order_id'        => $order->id,
                'order_number'    => $order->order_number,
                'user_id'         => $order->user_id,
                'pricing_plan_id' => $order->pricing_plan_id,
            ]
        ];

        // Endpoints to attempt (Standard v2 endpoints: /payments/checkout or /checkout)
        $endpoints = [
            $this->getApiUrl('payments/checkout'),
            $this->getApiUrl('checkout'),
        ];

        try {
            $lastResponse = null;

            foreach ($endpoints as $url) {
                Log::info('Moneybag Checkout Attempt', ['order' => $order->order_number, 'url' => $url]);

                $response = Http::timeout(25)->withHeaders([
                    'X-Merchant-API-Key' => $merchantKey,
                    'Accept'             => 'application/json',
                    'Content-Type'       => 'application/json',
                ])->post($url, $payload);

                $lastResponse = $response;

                if ($response->successful()) {
                    $data = $response->json();
                    Log::info('Moneybag Checkout Response Success', ['url' => $url, 'data' => $data]);

                    // Redirect customer to Moneybag payment gateway page
                    $redirectUrl = $data['redirect_url'] 
                        ?? $data['data']['redirect_url'] 
                        ?? $data['payment_url'] 
                        ?? $data['data']['payment_url']
                        ?? $data['checkout_url']
                        ?? $data['data']['checkout_url']
                        ?? null;

                    if (!empty($redirectUrl)) {
                        return redirect()->away($redirectUrl);
                    }

                    $errorMsg = $data['message'] ?? 'Payment URL was not provided by Moneybag.';
                    $order->update(['payment_status' => 'cancelled']);
                    return redirect()->route('user.checkout', $order->pricing_plan_id)->with('error', 'Gateway Error: ' . $errorMsg);
                }

                // If 404, continue to next possible v2 endpoint
                if ($response->status() !== 404) {
                    break;
                }
            }

            Log::error('Moneybag initiation failed', [
                'status' => $lastResponse ? $lastResponse->status() : null,
                'body'   => $lastResponse ? $lastResponse->body() : null,
            ]);

            $errBody = $lastResponse ? $lastResponse->json() : null;
            $errMessage = $errBody['message'] ?? 'Could not initialize Moneybag payment session (HTTP ' . ($lastResponse ? $lastResponse->status() : 500) . ').';

            $order->update(['payment_status' => 'cancelled']);
            return redirect()->route('user.checkout', $order->pricing_plan_id)->with('error', 'Moneybag: ' . $errMessage);
        } catch (\Throwable $e) {
            Log::error('Moneybag checkout exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            $order->update(['payment_status' => 'cancelled']);
            return redirect()->route('user.checkout', $order->pricing_plan_id)->with('error', 'Connection error to Moneybag: ' . $e->getMessage());
        }
    }

    /**
     * Handle Payment Success Redirect
     */
    public function success(Request $request): RedirectResponse
    {
        $orderNumber = $request->query('order_number') ?? $request->query('order_id') ?? $request->input('order_id');
        $transactionId = $request->query('transaction_id') ?? $request->query('txn_id') ?? $request->input('transaction_id');


        if (!$orderNumber && $transactionId) {
            $order = Order::where('gateway_txn_id', $transactionId)->first();
        } else {
            $order = Order::where('order_number', $orderNumber)->first();
        }

        if (!$order) {
            return redirect()->route('user.orders')->with('error', 'Order record not found for payment return.');
        }

        // Verify with Moneybag API server-to-server
        $verification = $this->verifyPayment($order->order_number, $transactionId);

        if ($verification['verified']) {
            $this->fulfillOrder($order, $verification['txn_id'] ?? $transactionId, $verification['data'] ?? []);
            return redirect()->route('user.orders')->with('success', 'Payment verified successfully! Order #' . $order->order_number . ' is confirmed. Our team will verify and provision your license.');
        }

        // If verification returned unconfirmed
        return redirect()->route('user.orders')->with('error', 'Payment verification could not be confirmed by the gateway. If debited, please contact support.');
    }

    /**
     * Handle Payment Failure
     */
    public function fail(Request $request): RedirectResponse
    {
        $orderNumber = $request->query('order_number') ?? $request->query('order_id');
        Log::warning('Moneybag Failed Callback', $request->all());

        if ($orderNumber) {
            $order = Order::where('order_number', $orderNumber)->first();
            if ($order) {
                $order->update(['payment_status' => 'failed']);
                try {
                    \App\Jobs\SendPaymentFailedEmailJob::dispatch($order->fresh());
                } catch (\Throwable $e) {
                    Log::error("Failed to dispatch payment failed email: " . $e->getMessage());
                }
            }
        }

        return redirect()->route('user.orders')->with('error', 'Payment transaction failed or was declined by the provider.');
    }

    /**
     * Handle Payment Cancellation
     */
    public function cancel(Request $request): RedirectResponse
    {
        $orderNumber = $request->query('order_number') ?? $request->query('order_id');
        Log::info('Moneybag Cancel Callback', $request->all());

        if ($orderNumber) {
            Order::where('order_number', $orderNumber)->update(['payment_status' => 'cancelled']);
        }

        return redirect()->route('user.orders')->with('info', 'Payment session was cancelled.');
    }

    /**
     * Server-to-Server Instant Payment Notification (IPN / Webhook)
     */
    public function handleIpn(Request $request)
    {
        Log::info('Moneybag IPN Received', $request->all());

        $orderNumber = $request->input('order_id') ?? $request->input('order_number');
        $transactionId = $request->input('transaction_id') ?? $request->input('txn_id');

        if (!$orderNumber) {
            return response()->json(['status' => 'error', 'message' => 'Missing order_id'], 400);
        }

        $order = Order::where('order_number', $orderNumber)->first();
        if (!$order) {
            return response()->json(['status' => 'error', 'message' => 'Order not found'], 404);
        }

        $verification = $this->verifyPayment($order->order_number, $transactionId);

        if ($verification['verified']) {
            $this->fulfillOrder($order, $verification['txn_id'] ?? $transactionId, $verification['data'] ?? []);
            return response()->json(['status' => 'success', 'message' => 'Payment verified and updated.'], 200);
        }

        return response()->json(['status' => 'failed', 'message' => 'Payment verification failed.'], 400);
    }

    /**
     * Server-side Verification Call against Moneybag API
     */
    private function verifyPayment(?string $orderId, ?string $transactionId = null): array
    {
        $moneybagMethod = $this->getMoneybagMethod();
        $merchantKey = $this->getMerchantKey($moneybagMethod);
        $queryParam = $transactionId ?: $orderId;

        if (empty($queryParam) || empty($merchantKey)) {
            return ['verified' => false, 'data' => null];
        }

        $endpoints = [
            $this->getApiUrl("payments/verify/{$queryParam}"),
            $this->getApiUrl("verify-payment/{$queryParam}"),
            $this->getApiUrl("verify/{$queryParam}"),
        ];

        foreach ($endpoints as $url) {
            try {
                $response = Http::timeout(20)->withHeaders([
                    'X-Merchant-API-Key' => $merchantKey,
                    'Accept'             => 'application/json',
                ])->get($url);

                Log::info('Moneybag Verify Response', ['url' => $url, 'body' => $response->body()]);

                if ($response->successful()) {
                    $data = $response->json();
                    $status = strtolower((string) ($data['status'] ?? $data['data']['status'] ?? ''));
                    $txn = $data['transaction_id'] ?? $data['data']['transaction_id'] ?? $data['txn_id'] ?? $transactionId;

                    if (in_array($status, ['paid', 'success', 'completed', 'successful'])) {
                        return [
                            'verified' => true,
                            'txn_id'   => $txn,
                            'data'     => $data,
                        ];
                    }
                }
            } catch (\Throwable $e) {
                Log::error('Moneybag verification exception: ' . $e->getMessage());
            }
        }

        return ['verified' => false, 'data' => null];
    }

    /**
     * Fulfill order in database
     */
    private function fulfillOrder(Order $order, ?string $txnId = null, array $gatewayData = []): void
    {
        $order->update([
            'payment_status'     => 'paid',
            'gateway_txn_id'     => $txnId ?: $order->gateway_txn_id,
            'gateway_response'   => !empty($gatewayData) ? json_encode($gatewayData) : $order->gateway_response,
            'paid_at'            => $order->paid_at ?? now(),
        ]);

        // Send App Notification to Customer
        \App\Models\AppNotification::send([
            'user_id'     => $order->user_id,
            'target_role' => 'user',
            'title'       => "Payment Received: #{$order->order_number}",
            'message'     => "Payment of ৳" . number_format($order->payable_amount, 2) . " verified via Moneybag. Order is awaiting admin approval.",
            'type'        => 'payment',
            'action_url'  => route('user.orders', [], false),
            'icon'        => 'fa-solid fa-circle-check',
            'color'       => 'emerald',
        ]);

        // Send App Notification to Admins
        \App\Models\AppNotification::send([
            'user_id'     => null,
            'target_role' => 'admin',
            'title'       => "Payment Confirmed: Order #{$order->order_number}",
            'message'     => "Payment of ৳" . number_format($order->payable_amount, 2) . " verified for {$order->plan_name}. Ready for approval.",
            'type'        => 'payment',
            'action_url'  => route('admin.orders.show', $order->id, false),
            'icon'        => 'fa-solid fa-money-bill-wave',
            'color'       => 'emerald',
        ]);

        // Dispatch Confirmation & Admin Alert Emails
        try {
            \App\Jobs\SendPaymentSuccessEmailJob::dispatch($order->fresh());
            \App\Jobs\SendAdminNewOrderAlertJob::dispatch($order->fresh());
        } catch (\Throwable $e) {
            Log::error("Failed to dispatch payment success/admin alert email for Order #{$order->order_number}: " . $e->getMessage());
        }
    }
}