<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScheduledSession extends Model
{
    protected $table = 'scheduled_sessions';

    protected $fillable = [
        'staff_scheduled_id',
        'session_number',
        'session_date',
        'start_time',
        'end_time',
        'meeting_url',
        'track_session_id',
        'staff_slot_id',
        'status',
    ];

    protected $casts = [
        // 'session_date' => 'date',
    ];

    public function staffScheduled()
    {
        return $this->belongsTo(StaffScheduled::class, 'staff_scheduled_id');
    }

    public function trackSession()
    {
        return $this->belongsTo(TrackLevelSession::class, 'track_session_id');
    }
}
