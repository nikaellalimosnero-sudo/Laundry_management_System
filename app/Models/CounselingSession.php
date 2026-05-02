<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

// This model represents a counseling session row in the database.
class CounselingSession extends Model
{
    protected $table = 'counseling_sessions';    // Explicitly set the table name

    protected $fillable = [
        'student_id', 'counselor_id',
        'scheduled_at', 'concern', 'notes', 'status',
    ];

    // Tell Laravel that 'scheduled_at' should be treated as a Carbon date object
    protected $casts = [
        'scheduled_at' => 'datetime',
    ];

    // ── Relationships ─────────────────────────────────────────────────
    // Each session belongs to ONE student
    public function student(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    // Each session belongs to ONE counselor
    public function counselor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'counselor_id');
    }

    // ── Helper to get a badge color based on status ───────────────────
    public function statusBadge(): string
    {
        return match($this->status) {
            'pending'   => 'warning',
            'ongoing'   => 'primary',
            'completed' => 'success',
            'cancelled' => 'danger',
            default     => 'secondary',
        };
    }
}
