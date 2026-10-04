<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ticket extends Model
{
    protected $fillable = [
        'ticket_number',
        'user_id',
        'subject',
        'department',
        'priority',
        'status',
        'message',
        'attachment',
        'last_reply_at',
        'is_read_by_admin',
        'is_read_by_user',
    ];

    protected $casts = [
        'last_reply_at'    => 'datetime',
        'is_read_by_admin' => 'boolean',
        'is_read_by_user'  => 'boolean',
    ];

    /**
     * User who created the ticket
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Replies for the ticket
     */
    public function replies(): HasMany
    {
        return $this->hasMany(TicketReply::class)->orderBy('created_at', 'asc');
    }

    /**
     * Get badge color class for status
     */
    public function getStatusBadgeAttribute(): string
    {
        return match ($this->status) {
            'open'           => 'bg-emerald-100 text-emerald-800 dark:bg-emerald-950/80 dark:text-emerald-300 border-emerald-200 dark:border-emerald-800',
            'answered'       => 'bg-blue-100 text-blue-800 dark:bg-blue-950/80 dark:text-blue-300 border-blue-200 dark:border-blue-800',
            'customer_reply' => 'bg-amber-100 text-amber-800 dark:bg-amber-950/80 dark:text-amber-300 border-amber-200 dark:border-amber-800',
            'in_progress'    => 'bg-purple-100 text-purple-800 dark:bg-purple-950/80 dark:text-purple-300 border-purple-200 dark:border-purple-800',
            'closed'         => 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-300 border-slate-200 dark:border-slate-700',
            default          => 'bg-slate-100 text-slate-700',
        };
    }

    /**
     * Get badge color class for priority
     */
    public function getPriorityBadgeAttribute(): string
    {
        return match ($this->priority) {
            'urgent' => 'bg-rose-100 text-rose-800 dark:bg-rose-950/80 dark:text-rose-300 border-rose-200 dark:border-rose-800',
            'high'   => 'bg-orange-100 text-orange-800 dark:bg-orange-950/80 dark:text-orange-300 border-orange-200 dark:border-orange-800',
            'medium' => 'bg-blue-100 text-blue-800 dark:bg-blue-950/80 dark:text-blue-300 border-blue-200 dark:border-blue-800',
            'low'    => 'bg-slate-100 text-slate-800 dark:bg-slate-800 dark:text-slate-300 border-slate-200 dark:border-slate-700',
            default  => 'bg-slate-100 text-slate-700',
        };
    }
}
