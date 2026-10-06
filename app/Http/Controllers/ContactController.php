<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    /**
     * Store a newly submitted contact inquiry message from the storefront.
     */
    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'name'    => ['required', 'string', 'max:255'],
            'email'   => ['required', 'email', 'max:255'],
            'phone'   => ['nullable', 'string', 'max:50'],
            'message' => ['required', 'string', 'max:5000'],
        ]);

        $message = ContactMessage::create([
            'name'       => $validated['name'],
            'email'      => $validated['email'],
            'phone'      => $validated['phone'] ?? null,
            'message'    => $validated['message'],
            'is_read'    => false,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        // 1. Send in-app notification to all Admins
        try {
            \App\Models\AppNotification::send([
                'user_id'     => null,
                'target_role' => 'admin',
                'title'       => 'New Contact Form Inquiry',
                'message'     => "{$message->name} ({$message->email}) sent an inquiry from the storefront contact form.",
                'type'        => 'contact',
                'action_url'  => route('admin.contact-messages.show', $message->id, false),
                'icon'        => 'fa-solid fa-envelope',
                'color'       => 'blue',
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning("Failed to create contact inquiry in-app notification: " . $e->getMessage());
        }

        // 2. Dispatch Email notification to configured Admin Notification Email
        try {
            \App\Jobs\SendContactInquiryEmailJob::dispatch($message);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Failed to dispatch contact inquiry email job: " . $e->getMessage());
        }

        return response()->json([
            'success' => true,
            'message' => 'Thank you! Your message has been received. Our Microsoft specialist team will contact you shortly.',
            'data'    => [
                'id'    => $message->id,
                'name'  => $message->name,
                'phone' => $message->phone,
            ],
        ], 201);
    }
}
