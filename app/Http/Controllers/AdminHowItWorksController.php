<?php

namespace App\Http\Controllers;

use App\Models\HowItWork;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminHowItWorksController extends Controller
{
    /**
     * Display a listing of all How It Works steps.
     */
    public function index(): View
    {
        $user = Auth::user();
        $steps = HowItWork::orderBy('sort_order', 'asc')->get();

        return view('admin.how-it-works.index', compact('user', 'steps'));
    }

    /**
     * Show the form for creating a new step.
     */
    public function create(): View
    {
        $user = Auth::user();
        return view('admin.how-it-works.create', compact('user'));
    }

    /**
     * Store a newly created step in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'step_number'   => ['nullable', 'string', 'max:50'],
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string'],
            'icon'          => ['required', 'string', 'max:100'],
            'icon_bg_color' => ['required', 'string', 'max:50'],
            'badge_text'    => ['nullable', 'string', 'max:150'],
            'badge_icon'    => ['nullable', 'string', 'max:100'],
            'badge_color'   => ['nullable', 'string', 'max:50'],
            'sort_order'    => ['nullable', 'integer'],
        ]);

        HowItWork::create([
            'step_number'   => $request->step_number,
            'title'         => $request->title,
            'description'   => $request->description,
            'icon'          => $request->icon,
            'icon_bg_color' => $request->icon_bg_color ?? 'sky',
            'badge_text'    => $request->badge_text,
            'badge_icon'    => $request->badge_icon ?? 'fa-solid fa-circle-check',
            'badge_color'   => $request->badge_color ?? 'emerald',
            'sort_order'    => $request->sort_order ?? (HowItWork::max('sort_order') + 1),
            'is_active'     => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.how-it-works.index')->with('success', 'New Step created successfully!');
    }

    /**
     * Show the form for editing the specified step.
     */
    public function edit(HowItWork $howItWork): View
    {
        $user = Auth::user();
        return view('admin.how-it-works.edit', compact('user', 'howItWork'));
    }

    /**
     * Update the specified step in storage.
     */
    public function update(Request $request, HowItWork $howItWork): RedirectResponse
    {
        $request->validate([
            'step_number'   => ['nullable', 'string', 'max:50'],
            'title'         => ['required', 'string', 'max:255'],
            'description'   => ['required', 'string'],
            'icon'          => ['required', 'string', 'max:100'],
            'icon_bg_color' => ['required', 'string', 'max:50'],
            'badge_text'    => ['nullable', 'string', 'max:150'],
            'badge_icon'    => ['nullable', 'string', 'max:100'],
            'badge_color'   => ['nullable', 'string', 'max:50'],
            'sort_order'    => ['nullable', 'integer'],
        ]);

        $howItWork->update([
            'step_number'   => $request->step_number,
            'title'         => $request->title,
            'description'   => $request->description,
            'icon'          => $request->icon,
            'icon_bg_color' => $request->icon_bg_color ?? 'sky',
            'badge_text'    => $request->badge_text,
            'badge_icon'    => $request->badge_icon ?? 'fa-solid fa-circle-check',
            'badge_color'   => $request->badge_color ?? 'emerald',
            'sort_order'    => $request->sort_order ?? 0,
            'is_active'     => $request->boolean('is_active'),
        ]);

        return redirect()->route('admin.how-it-works.index')->with('success', 'Step updated successfully!');
    }

    /**
     * Toggle the active status of a step via AJAX or form POST.
     */
    public function toggleStatus(HowItWork $howItWork): RedirectResponse
    {
        $howItWork->update([
            'is_active' => !$howItWork->is_active,
        ]);

        $statusMsg = $howItWork->is_active ? 'activated' : 'deactivated';
        return redirect()->route('admin.how-it-works.index')->with('success', "Step has been {$statusMsg} successfully!");
    }

    /**
     * Remove the specified step from storage.
     */
    public function destroy(HowItWork $howItWork): RedirectResponse
    {
        $howItWork->delete();
        return redirect()->route('admin.how-it-works.index')->with('success', 'Step deleted successfully!');
    }
}
