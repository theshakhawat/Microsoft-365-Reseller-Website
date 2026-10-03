<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\View\View;

class AdminUserController extends Controller
{
    /**
     * List users filtered by role ('user' for Customers, 'admin' for Admins).
     */
    public function index(Request $request): View
    {
        $role = $request->query('role', 'user');
        if (!in_array($role, ['user', 'admin'])) {
            $role = 'user';
        }

        $search = $request->query('search');

        $users = User::where('role', $role)
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('email', 'like', "%{$search}%")
                      ->orWhere('phone', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $stats = [
            'total_customers' => User::where('role', 'user')->count(),
            'active_customers' => User::where('role', 'user')->where('status', true)->count(),
            'total_admins' => User::where('role', 'admin')->count(),
            'active_admins' => User::where('role', 'admin')->where('status', true)->count(),
        ];

        return view('admin.users.index', compact('users', 'role', 'search', 'stats'));
    }

    /**
     * Show form for creating a new account (Customer or Admin).
     */
    public function create(Request $request): View
    {
        $defaultRole = $request->query('role', 'user');
        if (!in_array($defaultRole, ['user', 'admin'])) {
            $defaultRole = 'user';
        }

        return view('admin.users.create', compact('defaultRole'));
    }

    /**
     * Store a newly created user in database.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'phone'    => ['nullable', 'string', 'max:20'],
            'role'     => ['required', Rule::in(['user', 'admin'])],
            'password' => ['required', 'string', 'min:8'],
            'photo'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'status'   => ['nullable'],
        ]);

        $photoPath = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/profile');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            $file->move($destinationPath, $filename);
            $photoPath = 'uploads/profile/' . $filename;
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
            'photo'    => $photoPath,
            'status'   => $request->boolean('status', true),
        ]);

        $roleTitle = $request->role === 'admin' ? 'Administrator' : 'Customer';

        return redirect()->route('admin.users.index', ['role' => $request->role])
            ->with('success', "New {$roleTitle} account created successfully!");
    }

    /**
     * Show form for editing an existing account.
     */
    public function edit(User $user): View
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update user details in database.
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'name'     => ['required', 'string', 'max:255'],
            'email'    => ['required', 'string', 'email', 'max:255', Rule::unique('users', 'email')->ignore($user->id)],
            'phone'    => ['nullable', 'string', 'max:20'],
            'role'     => ['required', Rule::in(['user', 'admin'])],
            'password' => ['nullable', 'string', 'min:8'],
            'photo'    => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif,webp', 'max:2048'],
            'status'   => ['nullable'],
        ]);

        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->role = $request->role;
        $user->status = $request->boolean('status');

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        // Handle photo update
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $filename = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $destinationPath = public_path('uploads/profile');

            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            if ($user->photo && File::exists(public_path($user->photo))) {
                File::delete(public_path($user->photo));
            }

            $file->move($destinationPath, $filename);
            $user->photo = 'uploads/profile/' . $filename;
        }

        $user->save();

        $roleTitle = $user->role === 'admin' ? 'Administrator' : 'Customer';

        return redirect()->route('admin.users.index', ['role' => $user->role])
            ->with('success', "{$roleTitle} account updated successfully!");
    }

    /**
     * Toggle active/deactive status.
     */
    public function toggleStatus(User $user): RedirectResponse
    {
        // Prevent current logged-in admin from deactivating themselves
        if (Auth::id() === $user->id) {
            return back()->withErrors(['error' => 'You cannot deactivate your own active session!']);
        }

        $user->status = !$user->status;
        $user->save();

        $statusText = $user->status ? 'activated' : 'deactivated';

        return back()->with('success', "Account has been {$statusText} successfully!");
    }

    /**
     * Delete user account permanently.
     */
    public function destroy(User $user): RedirectResponse
    {
        // Prevent self-deletion
        if (Auth::id() === $user->id) {
            return back()->withErrors(['error' => 'You cannot delete your own logged-in admin account!']);
        }

        $role = $user->role;

        if ($user->photo && File::exists(public_path($user->photo))) {
            File::delete(public_path($user->photo));
        }

        $user->delete();

        return redirect()->route('admin.users.index', ['role' => $role])
            ->with('success', 'User account permanently deleted.');
    }
}
