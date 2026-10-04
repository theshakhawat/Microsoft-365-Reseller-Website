<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AppNotification extends Model
{
    protected $fillable = [
        'user_id',
        'target_role',
        'title',
        'message',
        'type',
        'action_url',
        'icon',
        'color',
        'is_read',
        'read_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * User associated with the notification
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Ensure internal URLs are always relative paths so session domain remains consistent.
     */
    public function getActionUrlAttribute($value): ?string
    {
        if (empty($value)) {
            return null;
        }

        // If it starts with http/https, parse it
        if (str_starts_with($value, 'http://') || str_starts_with($value, 'https://')) {
            $parsed = parse_url($value);
            $host = $parsed['host'] ?? '';
            $currentHost = request()->getHost();

            // If it belongs to local/current domain, return relative path
            if (in_array($host, ['localhost', '127.0.0.1', $currentHost]) || empty($host)) {
                $path = $parsed['path'] ?? '/';
                if (!empty($parsed['query'])) {
                    $path .= '?' . $parsed['query'];
                }
                return $path;
            }
        }

        return $value;
    }

    /**
     * Helper to send notification easily from anywhere in the app
     */
    public static function send(array $data): self
    {
        $actionUrl = $data['action_url'] ?? null;
        if (!empty($actionUrl) && (str_starts_with($actionUrl, 'http://') || str_starts_with($actionUrl, 'https://'))) {
            $parsed = parse_url($actionUrl);
            $path = $parsed['path'] ?? '/';
            if (!empty($parsed['query'])) {
                $path .= '?' . $parsed['query'];
            }
            $actionUrl = $path;
        }

        return self::create([
            'user_id'     => $data['user_id'] ?? null,
            'target_role' => $data['target_role'] ?? null,
            'title'       => $data['title'] ?? 'Notification',
            'message'     => $data['message'] ?? '',
            'type'        => $data['type'] ?? 'info',
            'action_url'  => $actionUrl,
            'icon'        => $data['icon'] ?? 'fa-solid fa-bell',
            'color'       => $data['color'] ?? 'blue',
            'is_read'     => false,
        ]);
    }
}
