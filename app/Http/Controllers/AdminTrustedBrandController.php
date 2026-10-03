<?php

namespace App\Http\Controllers;

use App\Models\TrustedBrand;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class AdminTrustedBrandController extends Controller
{
    /**
     * Display a listing of all trusted brands.
     */
    public function index(): View
    {
        $user = Auth::user();
        $brands = TrustedBrand::orderBy('sort_order', 'asc')->get();

        $stats = [
            'total'  => TrustedBrand::count(),
            'active' => TrustedBrand::where('is_active', true)->count(),
            'hidden' => TrustedBrand::where('is_active', false)->count(),
        ];

        return view('admin.trusted-brands.index', compact('user', 'brands', 'stats'));
    }

    /**
     * Show the form for creating a new trusted brand.
     */
    public function create(): View
    {
        $user = Auth::user();
        return view('admin.trusted-brands.create', compact('user'));
    }

    /**
     * Store a newly created trusted brand in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'website_url'  => ['nullable', 'string', 'max:255'],
            'logo_image'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:4096'],
            'preset_logo'  => ['nullable', 'string', 'max:255'],
            'sort_order'   => ['nullable', 'integer'],
        ]);

        $logoPath = null;

        if ($request->hasFile('logo_image')) {
            $image = $request->file('logo_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/brands');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);
            $logoPath = 'uploads/brands/' . $filename;
        } elseif ($request->filled('preset_logo')) {
            $logoPath = $request->preset_logo;
        }

        if (!$logoPath) {
            return back()->withInput()->withErrors(['logo_image' => 'Please provide a logo image or select a preset logo.']);
        }

        TrustedBrand::create([
            'name'        => $request->name,
            'logo_image'  => $logoPath,
            'website_url' => $request->website_url,
            'sort_order'  => $request->sort_order ?? (TrustedBrand::max('sort_order') + 1),
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.trusted-brands.index')
            ->with('success', 'Brand logo added successfully!');
    }

    /**
     * Show the form for editing the specified trusted brand.
     */
    public function edit(TrustedBrand $trustedBrand): View
    {
        $user = Auth::user();
        return view('admin.trusted-brands.edit', compact('user', 'trustedBrand'));
    }

    /**
     * Update the specified trusted brand in storage.
     */
    public function update(Request $request, TrustedBrand $trustedBrand): RedirectResponse
    {
        $request->validate([
            'name'         => ['required', 'string', 'max:255'],
            'website_url'  => ['nullable', 'string', 'max:255'],
            'logo_image'   => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:4096'],
            'preset_logo'  => ['nullable', 'string', 'max:255'],
            'sort_order'   => ['nullable', 'integer'],
        ]);

        $logoPath = $trustedBrand->logo_image;

        if ($request->hasFile('logo_image')) {
            // Delete old uploaded file if stored in uploads directory
            if ($trustedBrand->logo_image && str_starts_with($trustedBrand->logo_image, 'uploads/brands/') && File::exists(public_path($trustedBrand->logo_image))) {
                File::delete(public_path($trustedBrand->logo_image));
            }

            $image = $request->file('logo_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/brands');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);
            $logoPath = 'uploads/brands/' . $filename;
        } elseif ($request->filled('preset_logo')) {
            $logoPath = $request->preset_logo;
        }

        $trustedBrand->update([
            'name'        => $request->name,
            'logo_image'  => $logoPath,
            'website_url' => $request->website_url,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.trusted-brands.index')
            ->with('success', 'Brand logo updated successfully!');
    }

    /**
     * Toggle the active status of a trusted brand.
     */
    public function toggleStatus(TrustedBrand $trustedBrand): RedirectResponse
    {
        $trustedBrand->update([
            'is_active' => !$trustedBrand->is_active,
        ]);

        $statusMsg = $trustedBrand->is_active ? 'activated' : 'hidden';
        return back()->with('success', "Brand '{$trustedBrand->name}' has been {$statusMsg} successfully!");
    }

    /**
     * Remove the specified trusted brand from storage.
     */
    public function destroy(TrustedBrand $trustedBrand): RedirectResponse
    {
        if ($trustedBrand->logo_image && str_starts_with($trustedBrand->logo_image, 'uploads/brands/') && File::exists(public_path($trustedBrand->logo_image))) {
            File::delete(public_path($trustedBrand->logo_image));
        }

        $trustedBrand->delete();
        return back()->with('success', "Brand '{$trustedBrand->name}' deleted successfully!");
    }
}
