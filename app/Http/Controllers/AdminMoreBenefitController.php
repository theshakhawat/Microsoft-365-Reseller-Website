<?php

namespace App\Http\Controllers;

use App\Models\MoreBenefit;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class AdminMoreBenefitController extends Controller
{
    /**
     * Display a listing of all benefit cards.
     */
    public function index(): View
    {
        $user = Auth::user();
        $benefits = MoreBenefit::orderBy('sort_order', 'asc')->get();

        $stats = [
            'total'  => MoreBenefit::count(),
            'active' => MoreBenefit::where('is_active', true)->count(),
            'hidden' => MoreBenefit::where('is_active', false)->count(),
        ];

        return view('admin.more-benefits.index', compact('user', 'benefits', 'stats'));
    }

    /**
     * Show the form for creating a new benefit card.
     */
    public function create(): View
    {
        $user = Auth::user();
        return view('admin.more-benefits.create', compact('user'));
    }

    /**
     * Store a newly created benefit card in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon_image'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:4096'],
            'preset_icon' => ['nullable', 'string', 'max:255'],
            'sort_order'  => ['nullable', 'integer'],
        ]);

        $imagePath = null;

        if ($request->hasFile('icon_image')) {
            $image = $request->file('icon_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/benefits');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);
            $imagePath = 'uploads/benefits/' . $filename;
        } elseif ($request->filled('preset_icon')) {
            $imagePath = $request->preset_icon;
        }

        if (!$imagePath) {
            return back()->withInput()->withErrors(['icon_image' => 'Please provide an icon image or choose a preset icon.']);
        }

        MoreBenefit::create([
            'title'       => $request->title,
            'description' => $request->description,
            'icon_image'  => $imagePath,
            'sort_order'  => $request->sort_order ?? (MoreBenefit::max('sort_order') + 1),
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.more-benefits.index')
            ->with('success', 'Benefit card added successfully!');
    }

    /**
     * Show the form for editing the specified benefit card.
     */
    public function edit(MoreBenefit $moreBenefit): View
    {
        $user = Auth::user();
        return view('admin.more-benefits.edit', compact('user', 'moreBenefit'));
    }

    /**
     * Update the specified benefit card in storage.
     */
    public function update(Request $request, MoreBenefit $moreBenefit): RedirectResponse
    {
        $request->validate([
            'title'       => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'icon_image'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:4096'],
            'preset_icon' => ['nullable', 'string', 'max:255'],
            'sort_order'  => ['nullable', 'integer'],
        ]);

        $imagePath = $moreBenefit->icon_image;

        if ($request->hasFile('icon_image')) {
            // Delete old uploaded file if stored in uploads directory
            if ($moreBenefit->icon_image && str_starts_with($moreBenefit->icon_image, 'uploads/benefits/') && File::exists(public_path($moreBenefit->icon_image))) {
                File::delete(public_path($moreBenefit->icon_image));
            }

            $image = $request->file('icon_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/benefits');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);
            $imagePath = 'uploads/benefits/' . $filename;
        } elseif ($request->filled('preset_icon')) {
            $imagePath = $request->preset_icon;
        }

        $moreBenefit->update([
            'title'       => $request->title,
            'description' => $request->description,
            'icon_image'  => $imagePath,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.more-benefits.index')
            ->with('success', 'Benefit card updated successfully!');
    }

    /**
     * Toggle the active status of a benefit card.
     */
    public function toggleStatus(MoreBenefit $moreBenefit): RedirectResponse
    {
        $moreBenefit->update([
            'is_active' => !$moreBenefit->is_active,
        ]);

        $statusMsg = $moreBenefit->is_active ? 'activated' : 'hidden';
        return back()->with('success', "Benefit card has been {$statusMsg} successfully!");
    }

    /**
     * Remove the specified benefit card from storage.
     */
    public function destroy(MoreBenefit $moreBenefit): RedirectResponse
    {
        if ($moreBenefit->icon_image && str_starts_with($moreBenefit->icon_image, 'uploads/benefits/') && File::exists(public_path($moreBenefit->icon_image))) {
            File::delete(public_path($moreBenefit->icon_image));
        }

        $moreBenefit->delete();
        return back()->with('success', 'Benefit card deleted successfully!');
    }
}
