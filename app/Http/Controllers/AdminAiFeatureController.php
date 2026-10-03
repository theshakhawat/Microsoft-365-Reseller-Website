<?php

namespace App\Http\Controllers;

use App\Models\AiFeature;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class AdminAiFeatureController extends Controller
{
    /**
     * Display a listing of all AI feature cards.
     */
    public function index(): View
    {
        $user = Auth::user();
        $features = AiFeature::orderBy('sort_order', 'asc')->get();

        $stats = [
            'total'  => AiFeature::count(),
            'active' => AiFeature::where('is_active', true)->count(),
            'hidden' => AiFeature::where('is_active', false)->count(),
        ];

        return view('admin.ai-features.index', compact('user', 'features', 'stats'));
    }

    /**
     * Show the form for creating a new AI feature card.
     */
    public function create(): View
    {
        $user = Auth::user();
        return view('admin.ai-features.create', compact('user'));
    }

    /**
     * Store a newly created AI feature card in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'badge'        => ['nullable', 'string', 'max:100'],
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string'],
            'image'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:8192'],
            'preset_image' => ['nullable', 'string', 'max:255'],
            'link_url'     => ['nullable', 'string', 'max:255'],
            'link_text'    => ['nullable', 'string', 'max:100'],
            'sort_order'   => ['nullable', 'integer'],
        ]);

        $imagePath = null;

        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/ai-features');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);
            $imagePath = 'uploads/ai-features/' . $filename;
        } elseif ($request->filled('preset_image')) {
            $imagePath = $request->preset_image;
        }

        if (!$imagePath) {
            return back()->withInput()->withErrors(['image' => 'Please upload an image or choose a preset illustration image.']);
        }

        AiFeature::create([
            'badge'       => $request->badge,
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imagePath,
            'link_url'    => $request->link_url ?? '#plans',
            'link_text'   => $request->link_text ?? 'See Copilot plans',
            'sort_order'  => $request->sort_order ?? (AiFeature::max('sort_order') + 1),
            'is_active'   => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.ai-features.index')
            ->with('success', 'AI feature card added successfully!');
    }

    /**
     * Show the form for editing the specified AI feature card.
     */
    public function edit(AiFeature $aiFeature): View
    {
        $user = Auth::user();
        return view('admin.ai-features.edit', compact('user', 'aiFeature'));
    }

    /**
     * Update the specified AI feature card in storage.
     */
    public function update(Request $request, AiFeature $aiFeature): RedirectResponse
    {
        $request->validate([
            'badge'        => ['nullable', 'string', 'max:100'],
            'title'        => ['required', 'string', 'max:255'],
            'description'  => ['required', 'string'],
            'image'        => ['nullable', 'image', 'mimes:jpeg,png,jpg,webp,svg', 'max:8192'],
            'preset_image' => ['nullable', 'string', 'max:255'],
            'link_url'     => ['nullable', 'string', 'max:255'],
            'link_text'    => ['nullable', 'string', 'max:100'],
            'sort_order'   => ['nullable', 'integer'],
        ]);

        $imagePath = $aiFeature->image;

        if ($request->hasFile('image')) {
            // Delete old uploaded file if stored in uploads directory
            if ($aiFeature->image && str_starts_with($aiFeature->image, 'uploads/ai-features/') && File::exists(public_path($aiFeature->image))) {
                File::delete(public_path($aiFeature->image));
            }

            $image = $request->file('image');
            $filename = time() . '_' . uniqid() . '.' . $image->getClientOriginalExtension();
            $destinationPath = public_path('uploads/ai-features');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $image->move($destinationPath, $filename);
            $imagePath = 'uploads/ai-features/' . $filename;
        } elseif ($request->filled('preset_image')) {
            $imagePath = $request->preset_image;
        }

        $aiFeature->update([
            'badge'       => $request->badge,
            'title'       => $request->title,
            'description' => $request->description,
            'image'       => $imagePath,
            'link_url'    => $request->link_url ?? '#plans',
            'link_text'   => $request->link_text ?? 'See Copilot plans',
            'sort_order'  => $request->sort_order ?? 0,
            'is_active'   => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.ai-features.index')
            ->with('success', 'AI feature card updated successfully!');
    }

    /**
     * Toggle the active status of an AI feature card.
     */
    public function toggleStatus(AiFeature $aiFeature): RedirectResponse
    {
        $aiFeature->update([
            'is_active' => !$aiFeature->is_active,
        ]);

        $statusMsg = $aiFeature->is_active ? 'activated' : 'hidden';
        return back()->with('success', "AI feature card has been {$statusMsg} successfully!");
    }

    /**
     * Remove the specified AI feature card from storage.
     */
    public function destroy(AiFeature $aiFeature): RedirectResponse
    {
        if ($aiFeature->image && str_starts_with($aiFeature->image, 'uploads/ai-features/') && File::exists(public_path($aiFeature->image))) {
            File::delete(public_path($aiFeature->image));
        }

        $aiFeature->delete();
        return back()->with('success', 'AI feature card deleted successfully!');
    }
}
