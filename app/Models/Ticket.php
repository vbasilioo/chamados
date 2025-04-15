<?php

namespace App\Models;

use App\Enums\TicketPriority;
use App\Enums\TicketStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ticket extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'user_id',
        'assigned_to',
        'status',
        'priority',
        'category_id',
    ];

    protected $casts = [
        'status' => TicketStatus::class,
        'priority' => TicketPriority::class,
    ];

    /**
     * Get the user that created the ticket.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the user assigned to the ticket.
     */
    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    /**
     * Get the category of the ticket.
     */
    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the comments for the ticket.
     */
    public function comments(): HasMany
    {
        return $this->hasMany(TicketComment::class);
    }

    /**
     * Scope a query to only include tickets with a specific status.
     */
    public function scopeWithStatus($query, TicketStatus $status)
    {
        return $query->where('status', $status);
    }

    /**
     * Scope a query to only include tickets with a specific priority.
     */
    public function scopeWithPriority($query, TicketPriority $priority)
    {
        return $query->where('priority', $priority);
    }

    /**
     * Scope a query to only include tickets assigned to a specific user.
     */
    public function scopeAssignedTo($query, User $user)
    {
        return $query->where('assigned_to', $user->id);
    }
}
