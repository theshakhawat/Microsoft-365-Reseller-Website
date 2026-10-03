<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class AdminProfileController extends Controller
{
    /**
     * Show the dedicated Admin Profile Settings page.
     */
    public function profile(): View
    {
        $user = Auth::user();

        return view('admin.profile', compact('user'));
    }

    /**
     * Update admin profile details & avatar photo.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'photo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
        ]);

        $user->name = $request->name;
        $user->phone = $request->phone;

        // Handle profile photo upload
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = 'admin_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/profile');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Remove old photo if exists
            if ($user->photo && File::exists(public_path($user->photo))) {
                File::delete(public_path($user->photo));
            }

            $file->move($destinationPath, $filename);
            $user->photo = 'uploads/profile/' . $filename;
        }

        $user->save();

        return back()->with('success', 'Admin profile details updated successfully!');
    }

    /**
     * Show the dedicated Admin Change Password page.
     */
    public function changePassword(): View
    {
        $user = Auth::user();

        return view('admin.change-password', compact('user'));
    }

    /**
     * Update admin password with security checks.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'current_password' => ['required', 'string'],
            'password'         => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        // Verify current password
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided current password does not match our records.']);
        }

        // Prevent setting identical password
        if (Hash::check($request->password, $user->password)) {
            return back()->withErrors(['password' => 'New password cannot be the same as your current password.']);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        return back()->with('success', 'Admin password changed successfully!');
    }
}
