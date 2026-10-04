<?php

namespace App\Console\Commands;

use App\Jobs\SendSubscriptionStatusEmailJob;
use App\Models\AppNotification;
use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckExpiredSubscriptionsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Scan and mark past-due active subscriptions as expired and notify customers.';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $this->info('[' . now()->toDateTimeString() . '] Starting expired subscriptions audit...');

        $expiredSubscriptions = Subscription::where('status', 'active')
            ->whereNotNull('expires_at')
            ->where('expires_at', '<=', now())
            ->with(['user', 'pricingPlan'])
            ->get();

        $count = $expiredSubscriptions->count();

        if ($count === 0) {
            $this->info('No active subscriptions found past their expiration date.');
            return Command::SUCCESS;
        }

        $this->warn("Found {$count} expired active subscription(s). Processing status updates...");

        foreach ($expiredSubscriptions as $subscription) {
            $formattedExpiry = $subscription->expires_at ? $subscription->expires_at->format('M d, Y') : 'today';

            $subscription->update([
                'status'      => 'expired',
                'admin_notes' => ($subscription->admin_notes ? $subscription->admin_notes . "\n" : '') . "Automatically marked as expired on " . now()->toFormattedDateString() . " by system scheduler.",
            ]);

            // 1. Send in-app notification to customer
            try {
                AppNotification::send([
                    'user_id'     => $subscription->user_id,
                    'target_role' => 'user',
                    'title'       => "Subscription Expired: {$subscription->plan_name} ⏳",
                    'message'     => "Your {$subscription->plan_name} subscription has expired ({$formattedExpiry}). Renew now to maintain your 1TB cloud storage & apps.",
                    'type'        => 'subscription',
                    'action_url'  => route('user.plans'),
                    'icon'        => 'fa-solid fa-clock-rotate-left',
                    'color'       => 'amber',
                ]);
            } catch (\Throwable $e) {
                Log::warning("Failed to send in-app expiration notice for subscription #{$subscription->id}: " . $e->getMessage());
            }

            // 2. Dispatch queued expiration email
            try {
                SendSubscriptionStatusEmailJob::dispatch($subscription->fresh(), 'expired');
            } catch (\Throwable $e) {
                Log::error("Failed to queue expiration email for subscription #{$subscription->id}: " . $e->getMessage());
            }

            Log::info("Subscription #{$subscription->id} for customer ID {$subscription->user_id} ({$subscription->license_email}) automatically marked as expired.");
            $this->line(" - Subscription #{$subscription->id} ({$subscription->license_email} / {$subscription->plan_name}) updated to 'expired'.");
        }

        $this->info("Audit complete. Successfully processed and notified {$count} expired subscription(s).");
        return Command::SUCCESS;
    }
}
