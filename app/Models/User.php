<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'phone',
        'photo',
        'password',
        'role',
        'status',
        'push_notifications_enabled',
        'last_seen_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'status' => 'boolean',
            'push_notifications_enabled' => 'boolean',
            'last_seen_at' => 'datetime',
        ];
    }

    /**
     * Helper check for admin role
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Helper check for user role
     */
    public function isUser(): bool
    {
        return $this->role === 'user';
    }

    /**
     * User subscriptions relation.
     */
    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    /**
     * User orders relation.
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Check if user has an active non-expired subscription.
     */
    public function hasActiveSubscription(): bool
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->exists();
    }

    /**
     * Get active subscription model if available.
     */
    public function activeSubscription(): ?Subscription
    {
        return $this->subscriptions()
            ->where('status', 'active')
            ->where(function ($query) {
                $query->whereNull('expires_at')
                      ->orWhere('expires_at', '>', now());
            })
            ->latest()
            ->first();
    }

    /**
     * Check if user can order/upgrade to a target pricing plan.
     * Rules:
     * - No active subscription: Can buy any active plan.
     * - Same Plan / Tier: Allowed (extends validity).
     * - Higher Tier (e.g. Basic -> Personal): Allowed (upgrades plan & carries over remaining days).
     * - Lower Tier (e.g. Personal -> Basic): Disallowed while higher tier is active.
     */
    public function canPurchasePlan(PricingPlan $targetPlan): array
    {
        $activeSub = $this->activeSubscription();

        if (!$activeSub) {
            return ['allowed' => true, 'message' => null, 'is_upgrade' => false];
        }

        $activePlanName = strtolower($activeSub->plan_name ?: '');
        $targetPlanName = strtolower($targetPlan->name ?: '');

        // Determine current tier: 1 = Basic, 2 = Personal, 3 = Family, 4 = Business
        $tierMap = function (string $name): int {
            if (str_contains($name, 'business') || str_contains($name, 'enterprise')) return 4;
            if (str_contains($name, 'family')) return 3;
            if (str_contains($name, 'personal')) return 2;
            return 1; // Basic or standard
        };

        $currentTier = $tierMap($activePlanName);
        $targetTier = $tierMap($targetPlanName);

        // If target tier is higher than current tier (e.g. Basic -> Personal), ALLOW UPGRADE
        if ($targetTier > $currentTier) {
            return [
                'allowed'    => true,
                'message'    => 'Upgrading from ' . ($activeSub->plan_name ?: 'Basic') . ' to ' . $targetPlan->name . '. Your remaining days will be carried over!',
                'is_upgrade' => true,
            ];
        }

        // If trying to downgrade (e.g. Personal -> Basic) while active
        if ($targetTier < $currentTier) {
            return [
                'allowed'    => false,
                'message'    => 'You currently have an active ' . ($activeSub->plan_name ?: 'Personal') . ' subscription. Downgrading to ' . $targetPlan->name . ' while active is not allowed.',
                'is_upgrade' => false,
            ];
        }

        // Same plan / same tier: ALLOW RENEWAL / EXTENSION
        return [
            'allowed'    => true,
            'message'    => 'Renewing/extending your ' . ($activeSub->plan_name ?: 'subscription') . '. The new billing period will be added to your current validity!',
            'is_upgrade' => false,
        ];
    }

    /**
     * Check if user can buy or upgrade to any plan right now.
     */
    public function canAccessPlans(): bool
    {
        return true;
    }
}
