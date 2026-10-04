<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminPaymentMethodController extends Controller
{
    /**
     * Get available methods map from config/env with fallbacks.
     */
    protected function getAvailableSlugs(): array
    {
        $configured = config('payment.available_methods', []);

        if (empty($configured)) {
            $raw = env('Available_Payment_Mehtod') 
                ?? env('AVAILABLE_PAYMENT_METHODS') 
                ?? env('AVAILABLE_PAYMENT_METHOD') 
                ?? 'bkash,nagad,moneybag,paypal';

            $slugs = array_values(array_filter(array_map('trim', explode(',', strtolower($raw)))));
            $known = [
                'bkash'    => 'bKash',
                'nagad'    => 'Nagad',
                'moneybag' => 'MoneyBag',
                'paypal'   => 'PayPal',
            ];
            foreach ($slugs as $s) {
                $configured[$s] = $known[$s] ?? ucwords(str_replace(['_', '-'], ' ', $s));
            }
        }

        return $configured;
    }

    /**
     * Display a listing of all payment methods.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $search = trim($request->input('search', ''));
        $statusFilter = $request->input('status', 'all');

        $query = PaymentMethod::query();

        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('slug', 'LIKE', "%{$search}%")
                  ->orWhere('instruction', 'LIKE', "%{$search}%");
            });
        }

        if ($statusFilter === 'active') {
            $query->where('status', true);
        } elseif ($statusFilter === 'inactive') {
            $query->where('status', false);
        }

        $paymentMethods = $query->orderBy('sort_order', 'asc')->orderBy('created_at', 'desc')->get();

        $stats = [
            'total'    => PaymentMethod::count(),
            'active'   => PaymentMethod::where('status', true)->count(),
            'inactive' => PaymentMethod::where('status', false)->count(),
        ];

        return view('admin.payment-methods.index', compact('user', 'paymentMethods', 'stats', 'search', 'statusFilter'));
    }

    /**
     * Show the form for creating a new payment method.
     */
    public function create(): View
    {
        $user = Auth::user();
        $availableMethods = $this->getAvailableSlugs();

        return view('admin.payment-methods.create', compact('user', 'availableMethods'));
    }

    /**
     * Store a newly created payment method in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->merge([
            'slug' => strtolower(trim((string) $request->input('slug'))),
        ]);

        $request->validate([
            'name'         => ['required', 'string', 'max:100'],
            'slug'         => ['required', 'string', 'max:50', 'unique:payment_methods,slug'],
            'logo'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'logo_url'     => ['nullable', 'string', 'max:500'],
            'merchant_key' => ['nullable', 'string', 'max:500'],
            'base_url'     => ['nullable', 'string', 'max:500'],
            'api_secret'   => ['nullable', 'string', 'max:500'],
            'mode'         => ['nullable', 'string', 'in:live,sandbox'],
            'instruction'  => ['nullable', 'string', 'max:2000'],
            'sort_order'   => ['nullable', 'integer', 'min:0'],
        ]);

        $logoPath = $request->logo_url ?: null;

        if ($request->hasFile('logo')) {
            $file = $request->file('logo');
            $filename = 'pay_' . $request->slug . '_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/payment-methods');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $file->move($destinationPath, $filename);
            $logoPath = 'uploads/payment-methods/' . $filename;
        }

        PaymentMethod::create([
            'name'         => $request->name,
            'slug'         => $request->slug,
            'logo'         => $logoPath,
            'merchant_key' => $request->merchant_key,
            'base_url'     => $request->base_url,
            'api_secret'   => $request->api_secret,
            'mode'         => $request->mode ?? 'live',
            'instruction'  => $request->instruction,
            'sort_order'   => $request->sort_order ?? 0,
            'status'       => $request->boolean('status', true),
        ]);

        return redirect()->route('admin.payment-methods.index')->with('success', "Payment method '{$request->name}' added successfully!");
    }

    /**
     * Show the form for editing the specified payment method.
     */
    public function edit(PaymentMethod $paymentMethod): View
    {
        $user = Auth::user();
        $availableMethods = $this->getAvailableSlugs();

        // Ensure current slug is in the options list even if not in .env anymore
        if (!isset($availableMethods[$paymentMethod->slug])) {
            $availableMethods[$paymentMethod->slug] = ucwords(str_replace(['_', '-'], ' ', $paymentMethod->slug));
        }

        return view('admin.payment-methods.edit', compact('user', 'paymentMethod', 'availableMethods'));
    }

    /**
     * Update the specified payment method in storage.
     */
    public function update(Request $request, PaymentMethod $paymentMethod): RedirectResponse
    {
        $request->merge([
            'slug' => strtolower(trim((string) $request->input('slug'))),
        ]);

        $request->validate([
            'name'         => ['required', 'string', 'max:100'],
            'slug'         => ['required', 'string', 'max:50', Rule::unique('payment_methods', 'slug')->ignore($paymentMethod->id)],
            'logo'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:2048'],
            'logo_url'     => ['nullable', 'string', 'max:500'],
            'merchant_key' => ['nullable', 'string', 'max:500'],
            'base_url'     => ['nullable', 'string', 'max:500'],
            'api_secret'   => ['nullable', 'string', 'max:500'],
            'mode'         => ['nullable', 'string', 'in:live,sandbox'],
            'instruction'  => ['nullable', 'string', 'max:2000'],
            'sort_order'   => ['nullable', 'integer', 'min:0'],
        ]);

        $logoPath = $paymentMethod->logo;

        if ($request->filled('logo_url')) {
            $logoPath = $request->logo_url;
        }

        if ($request->hasFile('logo')) {
            // Delete old uploaded logo file
            if ($paymentMethod->logo && str_starts_with($paymentMethod->logo, 'uploads/payment-methods/') && File::exists(public_path($paymentMethod->logo))) {
                File::delete(public_path($paymentMethod->logo));
            }

            $file = $request->file('logo');
            $filename = 'pay_' . $request->slug . '_' . time() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/payment-methods');

            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $file->move($destinationPath, $filename);
            $logoPath = 'uploads/payment-methods/' . $filename;
        }

        $paymentMethod->update([
            'name'         => $request->name,
            'slug'         => $request->slug,
            'logo'         => $logoPath,
            'merchant_key' => $request->merchant_key,
            'base_url'     => $request->base_url,
            'api_secret'   => $request->api_secret,
            'mode'         => $request->mode ?? 'live',
            'instruction'  => $request->instruction,
            'sort_order'   => $request->sort_order ?? 0,
            'status'       => $request->boolean('status'),
        ]);

        return redirect()->route('admin.payment-methods.index')->with('success', "Payment method '{$paymentMethod->name}' updated successfully!");
    }

    /**
     * Toggle the active status of the payment method.
     */
    public function toggleStatus(PaymentMethod $paymentMethod): RedirectResponse
    {
        $paymentMethod->status = !$paymentMethod->status;
        $paymentMethod->save();

        $statusText = $paymentMethod->status ? 'activated' : 'deactivated';
        return back()->with('success', "Payment method '{$paymentMethod->name}' has been {$statusText}.");
    }

    /**
     * Remove the specified payment method from storage.
     */
    public function destroy(PaymentMethod $paymentMethod): RedirectResponse
    {
        $name = $paymentMethod->name;

        // Delete uploaded logo file if exists
        if ($paymentMethod->logo && str_starts_with($paymentMethod->logo, 'uploads/payment-methods/') && File::exists(public_path($paymentMethod->logo))) {
            File::delete(public_path($paymentMethod->logo));
        }

        $paymentMethod->delete();

        return redirect()->route('admin.payment-methods.index')->with('success', "Payment method '{$name}' deleted successfully!");
    }
}

