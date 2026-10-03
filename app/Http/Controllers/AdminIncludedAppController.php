<?php

namespace App\Http\Controllers;

use App\Models\IncludedApp;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class AdminIncludedAppController extends Controller
{
    /**
     * Display a listing of all Included Apps.
     */
    public function index(Request $request): View
    {
        $user = Auth::user();
        $category = $request->query('category', 'all');

        $query = IncludedApp::orderBy('category', 'asc')->orderBy('sort_order', 'asc');

        if ($category !== 'all') {
            $query->where('category', $category);
        }

        $apps = $query->get();

        $stats = [
            'total' => IncludedApp::count(),
            'productivity' => IncludedApp::where('category', 'productivity')->count(),
            'security' => IncludedApp::where('category', 'security')->count(),
            'active' => IncludedApp::where('is_active', true)->count(),
        ];

        return view('admin.included-apps.index', compact('user', 'apps', 'category', 'stats'));
    }

    /**
     * Show the form for creating a new Included App.
     */
    public function create(): View
    {
        $user = Auth::user();
        return view('admin.included-apps.create', compact('user'));
    }

    /**
     * Store a newly created Included App in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'category'    => ['required', 'string', 'in:productivity,security'],
            'name'        => ['required', 'string', 'max:255'],
            'tagline'     => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'link_url'    => ['nullable', 'string', 'max:255'],
            'link_text'   => ['nullable', 'string', 'max:100'],
            'icon_image'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:4096'],
            'preset_icon' => ['nullable', 'string', 'max:255'],
            'sort_order'  => ['nullable', 'integer'],
        ]);

        $imagePath = null;

        if ($request->hasFile('icon_image')) {
            $image = $request->file('icon_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/products');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);
            $imagePath = 'uploads/products/' . $filename;
        } elseif ($request->filled('preset_icon')) {
            $imagePath = $request->preset_icon;
        }

        IncludedApp::create([
            'category'    => $request->category,
            'name'        => $request->name,
            'tagline'     => $request->tagline,
            'description' => $request->description,
            'link_url'    => $request->link_url ?? '#plans',
            'link_text'   => $request->link_text ?? 'Learn more',
            'icon_image'  => $imagePath,
            'sort_order'  => $request->sort_order ?? (IncludedApp::where('category', $request->category)->max('sort_order') + 1),
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.included-apps.index', ['category' => $request->category])
            ->with('success', 'App card added successfully!');
    }

    /**
     * Show the form for editing the specified Included App.
     */
    public function edit(IncludedApp $includedApp): View
    {
        $user = Auth::user();
        return view('admin.included-apps.edit', compact('user', 'includedApp'));
    }

    /**
     * Update the specified Included App in storage.
     */
    public function update(Request $request, IncludedApp $includedApp): RedirectResponse
    {
        $request->validate([
            'category'    => ['required', 'string', 'in:productivity,security'],
            'name'        => ['required', 'string', 'max:255'],
            'tagline'     => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'link_url'    => ['nullable', 'string', 'max:255'],
            'link_text'   => ['nullable', 'string', 'max:100'],
            'icon_image'  => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:4096'],
            'preset_icon' => ['nullable', 'string', 'max:255'],
            'sort_order'  => ['nullable', 'integer'],
        ]);

        $imagePath = $includedApp->icon_image;

        if ($request->hasFile('icon_image')) {
            // Delete old uploaded file if stored in uploads directory
            if ($includedApp->icon_image && str_starts_with($includedApp->icon_image, 'uploads/products/') && File::exists(public_path($includedApp->icon_image))) {
                File::delete(public_path($includedApp->icon_image));
            }

            $image = $request->file('icon_image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/products');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);
            $imagePath = 'uploads/products/' . $filename;
        } elseif ($request->filled('preset_icon')) {
            $imagePath = $request->preset_icon;
        }

        $includedApp->update([
            'category'    => $request->category,
            'name'        => $request->name,
            'tagline'     => $request->tagline,
            'description' => $request->description,
            'link_url'    => $request->link_url ?? '#plans',
            'link_text'   => $request->link_text ?? 'Learn more',
            'icon_image'  => $imagePath,
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.included-apps.index', ['category' => $request->category])
            ->with('success', 'App card updated successfully!');
    }

    /**
     * Toggle the active status of an Included App.
     */
    public function toggleStatus(IncludedApp $includedApp): RedirectResponse
    {
        $includedApp->update([
            'is_active' => !$includedApp->is_active,
        ]);

        $statusMsg = $includedApp->is_active ? 'activated' : 'hidden';
        return back()->with('success', "App has been {$statusMsg} successfully!");
    }

    /**
     * Remove the specified Included App from storage.
     */
    public function destroy(IncludedApp $includedApp): RedirectResponse
    {
        if ($includedApp->icon_image && str_starts_with($includedApp->icon_image, 'uploads/products/') && File::exists(public_path($includedApp->icon_image))) {
            File::delete(public_path($includedApp->icon_image));
        }

        $includedApp->delete();
        return back()->with('success', 'App card deleted successfully!');
    }
}
