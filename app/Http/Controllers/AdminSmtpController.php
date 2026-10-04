<?php

namespace App\Http\Controllers;

use App\Models\SmtpSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\View\View;

class AdminSmtpController extends Controller
{
    /**
     * Show SMTP & Mail Configuration Page
     */
    public function edit(): View
    {
        $smtp = SmtpSetting::getSettings();
        return view('admin.smtp.edit', compact('smtp'));
    }

    /**
     * Update SMTP & Mail Settings in Database
     */
    public function update(Request $request): RedirectResponse
    {
        $request->validate([
            'mail_mailer'       => 'required|string|in:smtp,sendmail,log',
            'mail_host'         => 'nullable|string|max:255',
            'mail_port'         => 'nullable|numeric|between:1,65535',
            'mail_username'     => 'nullable|string|max:255',
            'mail_password'     => 'nullable|string',
            'mail_encryption'   => 'nullable|string|in:tls,ssl,starttls,none',
            'mail_from_address' => 'nullable|email|max:255',
            'mail_from_name'    => 'nullable|string|max:255',
            'is_active'         => 'nullable|boolean',
        ]);

        $smtp = SmtpSetting::getSettings();

        $encryption = $request->mail_encryption === 'none' ? null : $request->mail_encryption;

        $smtp->update([
            'mail_mailer'       => $request->mail_mailer,
            'mail_host'         => $request->mail_host,
            'mail_port'         => $request->mail_port ?: 587,
            'mail_username'     => $request->mail_username,
            'mail_password'     => $request->filled('mail_password') ? $request->mail_password : $smtp->mail_password,
            'mail_encryption'   => $encryption,
            'mail_from_address' => $request->mail_from_address,
            'mail_from_name'    => $request->mail_from_name,
            'is_active'         => $request->has('is_active') ? (bool) $request->is_active : true,
        ]);

        // Dynamically apply newly updated configuration
        SmtpSetting::applyConfig();

        return back()->with('success', 'SMTP & Mail configuration updated and applied successfully!');
    }

    /**
     * Send a Test Email using Laravel Job Queue
     */
    public function testMail(Request $request): RedirectResponse
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        $recipient = $request->input('test_email');

        try {
            // Apply current DB configuration first
            SmtpSetting::applyConfig();

            // Dispatch to Background Job Queue
            \App\Jobs\SendTestEmailJob::dispatch($recipient);

            return back()->with('test_success', "Test email job queued successfully for '{$recipient}'! It has been pushed to the background queue.");
        } catch (\Throwable $e) {
            Log::error('SMTP Test Mail Queue Exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('test_error', 'Queue Dispatch Error: ' . $e->getMessage());
        }
    }
}

