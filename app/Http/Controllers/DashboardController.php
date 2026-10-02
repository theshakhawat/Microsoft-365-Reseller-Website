<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class DashboardController extends Controller
{
    /**
     * Display the Admin Dashboard.
     */
    public function adminDashboard(): View
    {
        $user = Auth::user();

        // Sample metric counts and data for rich, realistic presentation
        $stats = [
            'total_users' => User::where('role', 'user')->count(),
            'active_licenses' => 142,
            'pending_orders' => 5,
            'monthly_revenue' => 387500,
        ];

        $recentUsers = User::latest()->take(6)->get();

        return view('admin.dashboard', compact('user', 'stats', 'recentUsers'));
    }

    /**
     * Display the User Dashboard.
     */
    public function userDashboard(): View
    {
        $user = Auth::user();

        return view('user.dashboard', compact('user'));
    }
}
