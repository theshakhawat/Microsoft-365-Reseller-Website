<?php

namespace App\Http\Controllers;

use App\Models\KeyFeature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class AdminKeyFeatureController extends Controller
{
    /**
     * Display a listing of all Key Features.
     */
    public function index(): View
    {
        $user = Auth::user();
        $features = KeyFeature::orderBy('sort_order', 'asc')->get();

        return view('admin.key-features.index', compact('user', 'features'));
    }

    /**
     * Show the form for creating a new Key Feature.
     */
    public function create(): View
    {
        $user = Auth::user();
        return view('admin.key-features.create', compact('user'));
    }

    /**
     * Store a newly created Key Feature in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string'],
            'icon'          => ['required', 'string', 'max:100'],
            'icon_bg_color' => ['required', 'string', 'max:50'],
            'link_url'      => ['nullable', 'string', 'max:255'],
            'link_text'     => ['nullable', 'string', 'max:100'],
            'image'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:4096'],
            'image_select'  => ['nullable', 'string', 'max:255'],
            'sort_order'    => ['nullable', 'integer'],
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/key-features');
            
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $filename);
            $imagePath = 'uploads/key-features/' . $filename;
        } elseif ($request->filled('image_select')) {
            $imagePath = $request->image_select;
        }

        KeyFeature::create([
            'title'         => $request->title,
            'description'   => $request->description,
            'icon'          => $request->icon,
            'icon_bg_color' => $request->icon_bg_color ?? 'purple',
            'link_url'      => $request->link_url ?? '#plans',
            'link_text'     => $request->link_text ?? 'Learn more',
            'image'         => $imagePath,
            'sort_order'    => $request->sort_order ?? (KeyFeature::max('sort_order') + 1),
            'is_active'     => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.key-features.index')->with('success', 'Key feature card created successfully!');
    }

    /**
     * Show the form for editing the specified Key Feature.
     */
    public function edit(KeyFeature $keyFeature): View
    {
        $user = Auth::user();
        return view('admin.key-features.edit', compact('user', 'keyFeature'));
    }

    /**
     * Update the specified Key Feature in storage.
     */
    public function update(Request $request, KeyFeature $keyFeature): RedirectResponse
    {
        $request->validate([
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string'],
            'icon'          => ['required', 'string', 'max:100'],
            'icon_bg_color' => ['required', 'string', 'max:50'],
            'link_url'      => ['nullable', 'string', 'max:255'],
            'link_text'     => ['nullable', 'string', 'max:100'],
            'image'         => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:4096'],
            'image_select'  => ['nullable', 'string', 'max:255'],
            'sort_order'    => ['nullable', 'integer'],
        ]);

        $imagePath = $keyFeature->image;

        if ($request->hasFile('image')) {
            // Delete old uploaded image if stored in uploads
            if ($keyFeature->image && str_starts_with($keyFeature->image, 'uploads/key-features/') && File::exists(public_path($keyFeature->image))) {
                File::delete(public_path($keyFeature->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/key-features');
            
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }
            
            $image->move($destinationPath, $filename);
            $imagePath = 'uploads/key-features/' . $filename;
        } elseif ($request->filled('image_select')) {
            $imagePath = $request->image_select;
        }

        $keyFeature->update([
            'title'         => $request->title,
            'description'   => $request->description,
            'icon'          => $request->icon,
            'icon_bg_color' => $request->icon_bg_color ?? 'purple',
            'link_url'      => $request->link_url ?? '#plans',
            'link_text'     => $request->link_text ?? 'Learn more',
            'image'         => $imagePath,
            'sort_order'    => $request->sort_order ?? 0,
            'is_active'     => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.key-features.index')->with('success', 'Key feature card updated successfully!');
    }

    /**
     * Toggle the active status of a Key Feature.
     */
    public function toggleStatus(KeyFeature $keyFeature): RedirectResponse
    {
        $keyFeature->update([
            'is_active' => !$keyFeature->is_active,
        ]);

        $statusMsg = $keyFeature->is_active ? 'activated' : 'hidden';
        return redirect()->route('admin.key-features.index')->with('success', "Feature has been {$statusMsg} successfully!");
    }

    /**
     * Remove the specified Key Feature from storage.
     */
    public function destroy(KeyFeature $keyFeature): RedirectResponse
    {
        if ($keyFeature->image && str_starts_with($keyFeature->image, 'uploads/key-features/') && File::exists(public_path($keyFeature->image))) {
            File::delete(public_path($keyFeature->image));
        }

        $keyFeature->delete();
        return redirect()->route('admin.key-features.index')->with('success', 'Key feature card deleted successfully!');
    }
}
