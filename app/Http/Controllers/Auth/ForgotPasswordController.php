<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\SendPasswordResetEmailJob;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class ForgotPasswordController extends Controller
{
    /**
     * Display the form to request a password reset link.
     */
    public function showLinkRequestForm(): View
    {
        return view('auth.forgot-password');
    }

    /**
     * Send a reset link to the given user.
     */
    public function sendResetLinkEmail(Request $request): RedirectResponse
    {
        $request->validate([
            'email' => ['required', 'string', 'email'],
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return back()->withErrors([
                'email' => "We couldn't find an account associated with this email address.",
            ])->onlyInput('email');
        }

        // Generate secure 64-character random token
        $plainToken = Str::random(64);

        // Remove any existing password reset token for this email
        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        // Store hashed token in database
        DB::table('password_reset_tokens')->insert([
            'email'      => $user->email,
            'token'      => Hash::make($plainToken),
            'created_at' => now(),
        ]);

        // Dispatch background email job
        try {
            SendPasswordResetEmailJob::dispatch($user, $plainToken);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Failed to queue password reset email: " . $e->getMessage());
        }

        return back()->with('status', 'We have emailed your password reset link! Please check your inbox or spam folder.');
    }

    /**
     * Display the password reset form.
     */
    public function showResetForm(Request $request, string $token): View
    {
        return view('auth.reset-password', [
            'token' => $token,
            'email' => $request->query('email', old('email')),
        ]);
    }

    /**
     * Reset the given user's password.
     */
    public function reset(Request $request): RedirectResponse
    {
        $request->validate([
            'token'    => ['required', 'string'],
            'email'    => ['required', 'string', 'email'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $resetRecord = DB::table('password_reset_tokens')->where('email', $request->email)->first();

        if (!$resetRecord) {
            return back()->withErrors([
                'email' => 'This password reset request is invalid or has already been used. Please request a new link.',
            ])->onlyInput('email');
        }

        // Validate expiration (60 minutes)
        $createdAt = Carbon::parse($resetRecord->created_at);
        if ($createdAt->addMinutes(60)->isPast()) {
            DB::table('password_reset_tokens')->where('email', $request->email)->delete();
            return back()->withErrors([
                'email' => 'This password reset link has expired. Please request a new one.',
            ])->onlyInput('email');
        }

        // Validate token hash
        if (!Hash::check($request->token, $resetRecord->token)) {
            return back()->withErrors([
                'email' => 'The password reset token is invalid. Please make sure you used the full link from your email.',
            ])->onlyInput('email');
        }

        // Find user
        $user = User::where('email', $request->email)->first();
        if (!$user) {
            return back()->withErrors([
                'email' => 'User account not found.',
            ])->onlyInput('email');
        }

        // Update password
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        // Invalidate reset token
        DB::table('password_reset_tokens')->where('email', $request->email)->delete();

        return redirect()->route('login')->with('status', 'Your password has been reset successfully! You can now sign in with your new password.');
    }
}
