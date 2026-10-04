<?php

namespace App\Http\Controllers;

use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminCouponController extends Controller
{
    /**
     * Display a listing of all coupon codes with search & filter.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $search = trim($request->input('search', ''));
        $statusFilter = $request->input('status', 'all');

        $query = Coupon::query();

        // Search by code or campaign name
        if ($search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('code', 'LIKE', "%{$search}%")
                  ->orWhere('name', 'LIKE', "%{$search}%");
            });
        }

        // Status filter
        $now = Carbon::now();
        if ($statusFilter === 'active') {
            $query->where('is_active', true)
                  ->where(function ($q) use ($now) {
                      $q->whereNull('start_date')->orWhere('start_date', '<=', $now);
                  })
                  ->where(function ($q) use ($now) {
                      $q->whereNull('expire_date')->orWhere('expire_date', '>=', $now);
                  });
        } elseif ($statusFilter === 'expired') {
            $query->where('expire_date', '<', $now);
        } elseif ($statusFilter === 'inactive') {
            $query->where('is_active', false);
        }

        $coupons = $query->orderBy('created_at', 'desc')->get();

        // Quick Stats
        $stats = [
            'total'       => Coupon::count(),
            'active'      => Coupon::where('is_active', true)
                                ->where(function ($q) use ($now) {
                                    $q->whereNull('expire_date')->orWhere('expire_date', '>=', $now);
                                })->count(),
            'expired'     => Coupon::whereNotNull('expire_date')->where('expire_date', '<', $now)->count(),
            'total_used'  => Coupon::sum('used_count'),
        ];

        return view('admin.coupons.index', compact('user', 'coupons', 'stats', 'search', 'statusFilter'));
    }

    /**
     * Show the form for creating a new coupon code.
     */
    public function create(): View
    {
        $user = Auth::user();
        return view('admin.coupons.create', compact('user'));
    }

    /**
     * Store a newly created coupon code in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        // Normalise code to uppercase without spaces
        $request->merge([
            'code' => strtoupper(trim((string) $request->input('code'))),
        ]);

        $request->validate([
            'code'                => ['required', 'string', 'max:50', 'unique:coupons,code'],
            'name'                => ['nullable', 'string', 'max:255'],
            'description'         => ['nullable', 'string', 'max:1000'],
            'discount_type'       => ['required', 'in:percentage,fixed'],
            'discount_value'      => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('discount_type') === 'percentage' && $value > 100) {
                        $fail('Percentage discount cannot exceed 100%.');
                    }
                },
            ],
            'min_order_amount'    => ['nullable', 'numeric', 'min:0'],
            'max_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'start_date'          => ['nullable', 'date'],
            'expire_date'         => ['nullable', 'date', 'after_or_equal:start_date'],
            'max_uses'            => ['nullable', 'integer', 'min:1'],
            'max_uses_per_user'   => ['nullable', 'integer', 'min:1'],
        ]);

        Coupon::create([
            'code'                => $request->code,
            'name'                => $request->name,
            'description'         => $request->description,
            'discount_type'       => $request->discount_type,
            'discount_value'      => $request->discount_value,
            'min_order_amount'    => $request->min_order_amount,
            'max_discount_amount' => $request->max_discount_amount,
            'start_date'          => $request->start_date,
            'expire_date'         => $request->expire_date,
            'max_uses'            => $request->max_uses,
            'max_uses_per_user'   => $request->max_uses_per_user ?? 1,
            'is_active'           => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.coupons.index')->with('success', "Coupon '{$request->code}' created successfully!");
    }

    /**
     * Show the form for editing the specified coupon.
     */
    public function edit(Coupon $coupon): View
    {
        $user = Auth::user();
        return view('admin.coupons.edit', compact('user', 'coupon'));
    }

    /**
     * Update the specified coupon code in storage.
     */
    public function update(Request $request, Coupon $coupon): RedirectResponse
    {
        // Normalise code to uppercase without spaces
        $request->merge([
            'code' => strtoupper(trim((string) $request->input('code'))),
        ]);

        $request->validate([
            'code'                => ['required', 'string', 'max:50', Rule::unique('coupons', 'code')->ignore($coupon->id)],
            'name'                => ['nullable', 'string', 'max:255'],
            'description'         => ['nullable', 'string', 'max:1000'],
            'discount_type'       => ['required', 'in:percentage,fixed'],
            'discount_value'      => [
                'required',
                'numeric',
                'min:0.01',
                function ($attribute, $value, $fail) use ($request) {
                    if ($request->input('discount_type') === 'percentage' && $value > 100) {
                        $fail('Percentage discount cannot exceed 100%.');
                    }
                },
            ],
            'min_order_amount'    => ['nullable', 'numeric', 'min:0'],
            'max_discount_amount' => ['nullable', 'numeric', 'min:0'],
            'start_date'          => ['nullable', 'date'],
            'expire_date'         => ['nullable', 'date', 'after_or_equal:start_date'],
            'max_uses'            => ['nullable', 'integer', 'min:1'],
            'max_uses_per_user'   => ['nullable', 'integer', 'min:1'],
        ]);

        $coupon->update([
            'code'                => $request->code,
            'name'                => $request->name,
            'description'         => $request->description,
            'discount_type'       => $request->discount_type,
            'discount_value'      => $request->discount_value,
            'min_order_amount'    => $request->min_order_amount,
            'max_discount_amount' => $request->max_discount_amount,
            'start_date'          => $request->start_date,
            'expire_date'         => $request->expire_date,
            'max_uses'            => $request->max_uses,
            'max_uses_per_user'   => $request->max_uses_per_user ?? 1,
            'is_active'           => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.coupons.index')->with('success', "Coupon '{$coupon->code}' updated successfully!");
    }

    /**
     * Toggle the active status of the coupon.
     */
    public function toggleStatus(Coupon $coupon): RedirectResponse
    {
        $coupon->is_active = !$coupon->is_active;
        $coupon->save();

        $statusText = $coupon->is_active ? 'activated' : 'deactivated';
        return back()->with('success', "Coupon '{$coupon->code}' has been {$statusText}.");
    }

    /**
     * Remove the specified coupon from storage.
     */
    public function destroy(Coupon $coupon): RedirectResponse
    {
        $code = $coupon->code;
        $coupon->delete();

        return redirect()->route('admin.coupons.index')->with('success', "Coupon '{$code}' deleted successfully!");
    }
}
