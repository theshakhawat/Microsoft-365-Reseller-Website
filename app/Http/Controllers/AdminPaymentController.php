<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminPaymentController extends Controller
{
    /**
     * Display listing of all transactions & payments across gateways.
     */
    public function index(Request $request): View
    {
        $query = Order::with(['user', 'paymentMethod'])->whereNotNull('payment_status');

        if ($request->filled('method')) {
            $query->where('payment_method_slug', $request->method);
        }

        if ($request->filled('status')) {
            $query->where('payment_status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('order_number', 'like', "%{$search}%")
                  ->orWhere('gateway_txn_id', 'like', "%{$search}%")
                  ->orWhere('gateway_txn_number', 'like', "%{$search}%")
                  ->orWhere('recipient_email', 'like', "%{$search}%");
            });
        }

        $payments = $query->latest()->paginate(15)->withQueryString();

        $totalRevenue = Order::where('payment_status', 'paid')->sum('payable_amount');
        $paymentMethods = PaymentMethod::all();

        $counts = [
            'total_revenue' => $totalRevenue,
            'paid_count'    => Order::where('payment_status', 'paid')->count(),
            'pending_count' => Order::where('payment_status', 'pending')->count(),
            'failed_count'  => Order::whereIn('payment_status', ['failed', 'cancelled'])->count(),
        ];

        return view('admin.payments.index', compact('payments', 'paymentMethods', 'counts'));
    }
}
