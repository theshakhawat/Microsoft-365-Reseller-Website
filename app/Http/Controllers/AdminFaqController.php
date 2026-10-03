<?php

namespace App\Http\Controllers;

use App\Models\Faq;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminFaqController extends Controller
{
    /**
     * Display a listing of all FAQ items.
     */
    public function index(): View
    {
        $user = Auth::user();
        $faqs = Faq::orderBy('sort_order', 'asc')->get();

        $stats = [
            'total'   => Faq::count(),
            'active'  => Faq::where('is_active', true)->count(),
            'hidden'  => Faq::where('is_active', false)->count(),
            'default_open' => Faq::where('is_default_open', true)->count(),
        ];

        return view('admin.faqs.index', compact('user', 'faqs', 'stats'));
    }

    /**
     * Show the form for creating a new FAQ item.
     */
    public function create(): View
    {
        $user = Auth::user();
        return view('admin.faqs.create', compact('user'));
    }

    /**
     * Store a newly created FAQ item in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'question'        => ['required', 'string', 'max:255'],
            'answer'          => ['required', 'string'],
            'sort_order'      => ['nullable', 'integer'],
            'is_default_open' => ['nullable', 'boolean'],
            'is_active'       => ['nullable', 'boolean'],
        ]);

        Faq::create([
            'question'        => $request->question,
            'answer'          => $request->answer,
            'sort_order'      => $request->sort_order ?? (Faq::max('sort_order') + 1),
            'is_default_open' => $request->boolean('is_default_open', false),
            'is_active'       => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ question added successfully!');
    }

    /**
     * Show the form for editing the specified FAQ item.
     */
    public function edit(Faq $faq): View
    {
        $user = Auth::user();
        return view('admin.faqs.edit', compact('user', 'faq'));
    }

    /**
     * Update the specified FAQ item in storage.
     */
    public function update(Request $request, Faq $faq): RedirectResponse
    {
        $request->validate([
            'question'        => ['required', 'string', 'max:255'],
            'answer'          => ['required', 'string'],
            'sort_order'      => ['nullable', 'integer'],
            'is_default_open' => ['nullable', 'boolean'],
            'is_active'       => ['nullable', 'boolean'],
        ]);

        $faq->update([
            'question'        => $request->question,
            'answer'          => $request->answer,
            'sort_order'      => $request->sort_order ?? $faq->sort_order,
            'is_default_open' => $request->boolean('is_default_open', false),
            'is_active'       => $request->boolean('is_active', true),
        ]);

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ question updated successfully!');
    }

    /**
     * Toggle the active status of the specified FAQ.
     */
    public function toggleStatus(Faq $faq): RedirectResponse
    {
        $faq->update(['is_active' => !$faq->is_active]);

        $status = $faq->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "FAQ has been {$status} successfully.");
    }

    /**
     * Remove the specified FAQ from storage.
     */
    public function destroy(Faq $faq): RedirectResponse
    {
        $faq->delete();

        return redirect()->route('admin.faqs.index')
            ->with('success', 'FAQ question deleted successfully!');
    }
}
