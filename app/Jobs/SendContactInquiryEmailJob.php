<?php

namespace App\Jobs;

use App\Models\ContactMessage;
use App\Models\SiteSetting;
use App\Models\SmtpSetting;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class SendContactInquiryEmailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Number of retry attempts
     */
    public int $tries = 3;

    /**
     * Timeout in seconds
     */
    public int $timeout = 60;

    /**
     * The contact message instance
     */
    public ContactMessage $contactMessage;

    /**
     * Create a new job instance.
     */
    public function __construct(ContactMessage $contactMessage)
    {
        $this->contactMessage = $contactMessage;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Apply fresh database SMTP configuration
        SmtpSetting::applyConfig();

        $contactMessage = $this->contactMessage;
        $appName = site_setting('site_name', config('app.name', 'Microsoft Office Club'));
        $fromAddress = config('mail.from.address', 'support@microsoftoffice.club');

        // Resolve Admin Recipient Email
        $adminEmail = site_setting('admin_notification_email', site_setting('contact_email', User::where('role', 'admin')->value('email')));

        if (empty($adminEmail)) {
            Log::warning("SendContactInquiryEmailJob: No admin notification email configured.");
            return;
        }

        try {
            $htmlContent = view('emails.contact-inquiry', compact('contactMessage'))->render();

            Mail::html($htmlContent, function ($message) use ($adminEmail, $contactMessage, $appName, $fromAddress) {
                $message->to($adminEmail)
                        ->from($fromAddress, $appName)
                        ->replyTo($contactMessage->email, $contactMessage->name)
                        ->subject("[New Inquiry] From {$contactMessage->name} - {$appName}");
            });

            Log::info("Contact inquiry notification email sent successfully to {$adminEmail} for message #{$contactMessage->id}");
        } catch (\Throwable $e) {
            Log::error("Failed to send contact inquiry notification email for message #{$contactMessage->id}: " . $e->getMessage());
            throw $e;
        }
    }
}
