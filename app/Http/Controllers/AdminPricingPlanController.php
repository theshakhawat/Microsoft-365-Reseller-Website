<?php

namespace App\Http\Controllers;

use App\Models\PricingPlan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AdminPricingPlanController extends Controller
{
    /**
     * Display a listing of all pricing plans for management.
     */
    public function index(): View
    {
        $user = Auth::user();
        $plans = PricingPlan::orderBy('sort_order', 'asc')->get();

        return view('admin.plans.index', compact('user', 'plans'));
    }

    /**
     * Show the form for creating a new pricing plan.
     */
    public function create(): View
    {
        $user = Auth::user();
        $availableApps = [
            'copilot'    => 'Copilot AI',
            'word'       => 'Microsoft Word',
            'excel'      => 'Microsoft Excel',
            'powerpoint' => 'PowerPoint',
            'outlook'    => 'Outlook',
            'teams'      => 'Microsoft Teams',
            'onedrive'   => 'OneDrive Cloud',
            'defender'   => 'Microsoft Defender',
            'sharepoint' => 'SharePoint',
            'onenote'    => 'OneNote',
            'forms'      => 'Forms',
            'planner'    => 'Planner',
            'power-automate' => 'Power Automate',
            'power-bi'   => 'Power BI',
        ];

        return view('admin.plans.create', compact('user', 'availableApps'));
    }

    /**
     * Store a newly created pricing plan in storage.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'badge'            => ['nullable', 'string', 'max:100'],
            'price_bdt'        => ['required', 'string', 'max:100'],
            'billing_period'   => ['required', 'string', 'max:50'],
            'price_usd'        => ['nullable', 'string', 'max:100'],
            'terms_text'       => ['nullable', 'string'],
            'button_text'      => ['required', 'string', 'max:100'],
            'button_url'       => ['nullable', 'string', 'max:500'],
            'features_heading' => ['nullable', 'string', 'max:255'],
            'features'         => ['required', 'string'], // newline separated
            'included_apps'    => ['nullable', 'array'],
            'sort_order'       => ['nullable', 'integer'],
        ]);

        // Convert newline-separated features into clean array
        $featuresArray = array_values(array_filter(array_map('trim', explode("\n", $request->features))));

        PricingPlan::create([
            'name'             => $request->name,
            'badge'            => $request->badge,
            'price_bdt'        => $request->price_bdt,
            'billing_period'   => $request->billing_period,
            'price_usd'        => $request->price_usd,
            'terms_text'       => $request->terms_text,
            'button_text'      => $request->button_text,
            'button_url'       => $request->button_url,
            'features_heading' => $request->features_heading,
            'features'         => $featuresArray,
            'included_apps'    => $request->included_apps ?? [],
            'is_featured'      => $request->boolean('is_featured'),
            'is_active'        => $request->boolean('is_active'),
            'sort_order'       => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.plans.index')->with('success', 'New Pricing Plan created successfully!');
    }

    /**
     * Show the form for editing the specified pricing plan.
     */
    public function edit(PricingPlan $plan): View
    {
        $user = Auth::user();
        $availableApps = [
            'copilot'    => 'Copilot AI',
            'word'       => 'Microsoft Word',
            'excel'      => 'Microsoft Excel',
            'powerpoint' => 'PowerPoint',
            'outlook'    => 'Outlook',
            'teams'      => 'Microsoft Teams',
            'onedrive'   => 'OneDrive Cloud',
            'defender'   => 'Microsoft Defender',
            'sharepoint' => 'SharePoint',
            'onenote'    => 'OneNote',
            'forms'      => 'Forms',
            'planner'    => 'Planner',
            'power-automate' => 'Power Automate',
            'power-bi'   => 'Power BI',
        ];

        return view('admin.plans.edit', compact('user', 'plan', 'availableApps'));
    }

    /**
     * Update the specified pricing plan in storage.
     */
    public function update(Request $request, PricingPlan $plan): RedirectResponse
    {
        $request->validate([
            'name'             => ['required', 'string', 'max:255'],
            'badge'            => ['nullable', 'string', 'max:100'],
            'price_bdt'        => ['required', 'string', 'max:100'],
            'billing_period'   => ['required', 'string', 'max:50'],
            'price_usd'        => ['nullable', 'string', 'max:100'],
            'terms_text'       => ['nullable', 'string'],
            'button_text'      => ['required', 'string', 'max:100'],
            'button_url'       => ['nullable', 'string', 'max:500'],
            'features_heading' => ['nullable', 'string', 'max:255'],
            'features'         => ['required', 'string'], // newline separated
            'included_apps'    => ['nullable', 'array'],
            'sort_order'       => ['nullable', 'integer'],
        ]);

        // Convert newline-separated features into clean array
        $featuresArray = array_values(array_filter(array_map('trim', explode("\n", $request->features))));

        $plan->update([
            'name'             => $request->name,
            'badge'            => $request->badge,
            'price_bdt'        => $request->price_bdt,
            'billing_period'   => $request->billing_period,
            'price_usd'        => $request->price_usd,
            'terms_text'       => $request->terms_text,
            'button_text'      => $request->button_text,
            'button_url'       => $request->button_url,
            'features_heading' => $request->features_heading,
            'features'         => $featuresArray,
            'included_apps'    => $request->included_apps ?? [],
            'is_featured'      => $request->boolean('is_featured'),
            'is_active'        => $request->boolean('is_active'),
            'sort_order'       => $request->sort_order ?? 0,
        ]);

        return redirect()->route('admin.plans.index')->with('success', 'Pricing Plan updated successfully!');
    }

    /**
     * Toggle active state of a plan.
     */
    public function toggleStatus(PricingPlan $plan): RedirectResponse
    {
        $plan->is_active = !$plan->is_active;
        $plan->save();

        return back()->with('success', 'Plan status toggled successfully!');
    }

    /**
     * Remove the specified pricing plan from storage.
     */
    public function destroy(PricingPlan $plan): RedirectResponse
    {
        $plan->delete();

        return redirect()->route('admin.plans.index')->with('success', 'Pricing Plan deleted successfully!');
    }
}
