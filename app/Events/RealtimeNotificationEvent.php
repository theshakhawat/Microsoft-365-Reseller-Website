<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealtimeNotificationEvent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ?string $targetRole;
    public ?int $userId;
    public array $payload;

    /**
     * Create a new event instance.
     */
    public function __construct(?string $targetRole, ?int $userId, array $payload)
    {
        $this->targetRole = $targetRole;
        $this->userId = $userId;
        $this->payload = $payload;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        $channels = [];

        // Broadcast to admin channel if notification is targeted to admin or all
        if ($this->targetRole === 'admin' || $this->targetRole === 'all') {
            $channels[] = new Channel('admin-notifications');
        }

        // Broadcast to specific user channel if targeted to a user
        if ($this->userId) {
            $channels[] = new Channel('user-notifications-' . $this->userId);
        }

        // Broadcast to global channel if targeted to all users
        if ($this->targetRole === 'user' && empty($this->userId)) {
            $channels[] = new Channel('all-users-notifications');
        }

        if (empty($channels)) {
            $channels[] = new Channel('admin-notifications');
        }

        return $channels;
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'notification.created';
    }

    /**
     * Get the data to broadcast.
     *
     * @return array<string, mixed>
     */
    public function broadcastWith(): array
    {
        return $this->payload;
    }
}
