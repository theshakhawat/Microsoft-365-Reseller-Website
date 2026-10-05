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
        $password = $request->filled('mail_password') ? trim((string) $request->mail_password) : $smtp->mail_password;

        $smtp->update([
            'mail_mailer'       => trim((string) $request->mail_mailer),
            'mail_host'         => trim((string) $request->mail_host),
            'mail_port'         => (int) ($request->mail_port ?: 587),
            'mail_username'     => trim((string) $request->mail_username),
            'mail_password'     => $password,
            'mail_encryption'   => $encryption,
            'mail_from_address' => trim((string) $request->mail_from_address),
            'mail_from_name'    => trim((string) $request->mail_from_name),
            'is_active'         => $request->has('is_active') ? (bool) $request->is_active : true,
        ]);

        // Dynamically apply newly updated configuration from Database
        SmtpSetting::applyConfig();

        return back()->with('success', 'Database SMTP & Mail configuration updated and applied successfully!');
    }

    /**
     * Send a Direct Diagnostic Test Email using Database SMTP Settings
     */
    public function testMail(Request $request): RedirectResponse
    {
        $request->validate([
            'test_email' => 'required|email',
        ]);

        $recipient = trim((string) $request->input('test_email'));

        try {
            // Apply current Database configuration first
            SmtpSetting::applyConfig();

            $appName = config('mail.from.name', 'Microsoft Office Club');
            $fromAddress = config('mail.from.address', 'support@microsoftoffice.club');
            $driver = config('mail.default', 'smtp');
            $host = config('mail.mailers.smtp.host', 'N/A');
            $port = config('mail.mailers.smtp.port', 'N/A');

            $htmlContent = "
                <div style='font-family: Arial, sans-serif; max-width: 600px; margin: 0 auto; padding: 24px; border: 1px solid #e2e8f0; border-radius: 12px; background-color: #ffffff;'>
                    <div style='text-align: center; margin-bottom: 20px;'>
                        <h2 style='color: #0067b8; margin: 0;'>{$appName}</h2>
                        <p style='color: #64748b; font-size: 14px; margin-top: 4px;'>Database SMTP Diagnostic Test Email</p>
                    </div>
                    <div style='background-color: #f0fdf4; border: 1px solid #bbf7d0; border-radius: 8px; padding: 16px; margin-bottom: 20px;'>
                        <p style='color: #166534; font-weight: bold; margin: 0 0 6px 0;'>✓ SMTP Connection & Authentication Successful!</p>
                        <p style='color: #15803d; font-size: 13px; margin: 0;'>Your database-driven SMTP server credentials are valid and working properly.</p>
                    </div>
                    <table style='width: 100%; border-collapse: collapse; font-size: 13px; margin-bottom: 20px;'>
                        <tr style='border-bottom: 1px solid #f1f5f9;'>
                            <td style='padding: 8px 0; color: #64748b; font-weight: bold;'>Configuration Source:</td>
                            <td style='padding: 8px 0; color: #166534; font-weight: bold; text-align: right;'>Database (smtp_settings)</td>
                        </tr>
                        <tr style='border-bottom: 1px solid #f1f5f9;'>
                            <td style='padding: 8px 0; color: #64748b; font-weight: bold;'>Mailer Driver:</td>
                            <td style='padding: 8px 0; color: #1e293b; text-align: right;'>" . strtoupper($driver) . "</td>
                        </tr>
                        <tr style='border-bottom: 1px solid #f1f5f9;'>
                            <td style='padding: 8px 0; color: #64748b; font-weight: bold;'>SMTP Host:</td>
                            <td style='padding: 8px 0; color: #1e293b; text-align: right;'>{$host}</td>
                        </tr>
                        <tr style='border-bottom: 1px solid #f1f5f9;'>
                            <td style='padding: 8px 0; color: #64748b; font-weight: bold;'>SMTP Port:</td>
                            <td style='padding: 8px 0; color: #1e293b; text-align: right;'>{$port}</td>
                        </tr>
                        <tr style='border-bottom: 1px solid #f1f5f9;'>
                            <td style='padding: 8px 0; color: #64748b; font-weight: bold;'>From Address:</td>
                            <td style='padding: 8px 0; color: #1e293b; text-align: right;'>{$fromAddress}</td>
                        </tr>
                        <tr>
                            <td style='padding: 8px 0; color: #64748b; font-weight: bold;'>Timestamp:</td>
                            <td style='padding: 8px 0; color: #1e293b; text-align: right;'>" . now()->format('Y-m-d H:i:s T') . "</td>
                        </tr>
                    </table>
                    <p style='color: #94a3b8; font-size: 12px; text-align: center; margin: 0;'>Sent via {$appName} Administration.</p>
                </div>
            ";

            Mail::html($htmlContent, function ($message) use ($recipient, $appName, $fromAddress) {
                $message->to($recipient)
                        ->from($fromAddress, $appName)
                        ->subject("Database SMTP Verification Test - {$appName}");
            });

            return back()->with('test_success', "Test email sent successfully to '{$recipient}'! Your database SMTP credentials are valid.");
        } catch (\Throwable $e) {
            Log::error('SMTP Test Mail Exception: ' . $e->getMessage(), ['trace' => $e->getTraceAsString()]);
            return back()->with('test_error', 'SMTP Authentication / Connection Error: ' . $e->getMessage());
        }
    }
}

