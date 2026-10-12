<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RetentionFeedback extends Model
{
    use HasFactory;

    protected $table = 'retention_feedback';

    protected $fillable = [
        'staff_id',
        'session_id',
        'camera_off',
        'virtual_background',
        'internet_not_stable',
        'class_room_not_suitable',
        'on_spot_absence',
        'delay_in_start',
        'minutes_delayed',
        'admin_comments',
        'review_status',
        'reviewed_by',
        'reviewed_at',
        'review_note',
    ];

    protected $casts = [
        'reviewed_at' => 'datetime',
    ];

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function session(): BelongsTo
    {
        return $this->belongsTo(ScheduledSession::class, 'session_id');
    }

    public function reviewer(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'reviewed_by');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('review_status', 'approved');
    }

    public function scopePendingReview(Builder $query): Builder
    {
        return $query->where('review_status', 'pending');
    }

    public function scopeRejected(Builder $query): Builder
    {
        return $query->where('review_status', 'rejected');
    }
}
