<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubSession extends Model
{
    protected $table = 'sub_sessions';

    protected $fillable = [
        'scheduled_session_id',
        'staff_scheduled_id',
        'staff_id',
        'track_id',
        'track_level_id',
        'track_session_id',
        'type',
        'status',
        'start_at',
        'end_at',
        'duration_minutes',
        'student_ids',
        'notes',
        'created_by',
    ];

    protected $casts = [
        'student_ids' => 'array',
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    public function scheduledSession()
    {
        return $this->belongsTo(ScheduledSession::class, 'scheduled_session_id');
    }

    public function scheduled()
    {
        return $this->belongsTo(StaffScheduled::class, 'staff_scheduled_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function trackSession()
    {
        return $this->belongsTo(TrackLevelSession::class, 'track_session_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
