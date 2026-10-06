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
            'mail_mailer'       => 'nullable|string|in:smtp,sendmail,log',
            'mail_host'         => 'nullable|string|max:255',
            'mail_port'         => 'nullable|numeric|between:1,65535',
            'mail_username'     => 'nullable|string|max:255',
            'mail_password'     => 'nullable|string|max:255',
            'mail_encryption'   => 'nullable|string|in:tls,ssl,starttls,none',
            'mail_from_address' => 'nullable|string|max:255',
            'mail_from_name'    => 'nullable|string|max:255',
            'is_active'         => 'nullable',
        ]);

        $smtp = SmtpSetting::getSettings();

        $mailer = $request->filled('mail_mailer') ? trim((string) $request->input('mail_mailer')) : 'smtp';
        $encryption = $request->input('mail_encryption');
        if ($encryption === 'none' || empty($encryption)) {
            $encryption = null;
        }

        $password = $request->has('mail_password') && $request->input('mail_password') !== null
            ? (string) $request->input('mail_password')
            : (string) ($smtp->mail_password ?? '');

        $isActive = $request->has('is_active')
            ? in_array($request->input('is_active'), [1, '1', true, 'true', 'on', 'yes'], true)
            : false;

        $smtp->mail_mailer       = $mailer;
        $smtp->mail_host         = trim((string) $request->input('mail_host', ''));
        $smtp->mail_port         = (int) ($request->input('mail_port') ?: 587);
        $smtp->mail_username     = trim((string) $request->input('mail_username', ''));
        $smtp->mail_password     = $password;
        $smtp->mail_encryption   = $encryption;
        $smtp->mail_from_address = trim((string) $request->input('mail_from_address', ''));
        $smtp->mail_from_name    = trim((string) $request->input('mail_from_name', ''));
        $smtp->is_active         = $isActive;
        $smtp->save();

        // Dynamically apply newly updated configuration from Database
        SmtpSetting::applyConfig();

        return back()->with('success', 'Database SMTP & Mail configuration updated and applied successfully!');
    }

    /**
     * Dispatch a Queued Test Email using Database SMTP Settings
     */
    public function testMail(Request $request): RedirectResponse
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        $recipient = trim((string) $request->input('test_email'));

        try {
            // Apply current Database configuration
            SmtpSetting::applyConfig();

            // Dispatch background queue job
            \App\Jobs\SendTestEmailJob::dispatch($recipient);

            return back()->with('test_success', "Test email has been queued successfully for '{$recipient}'! It is now in the background queue and will be processed by the queue worker.");
        } catch (\Throwable $e) {
            Log::error('SMTP Test Mail Dispatch Exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('test_error', 'Failed to dispatch queued test email: ' . $e->getMessage());
        }
    }
}
