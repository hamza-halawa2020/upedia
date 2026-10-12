<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PlacementTestBooking extends Model
{
    protected $fillable = [
        'course_student_id',
        'student_id',
        'assessment_type',
        'status',
        'staff_scheduled_id',
        'scheduled_session_id',
        'staff_id',
        'session_date',
        'start_time',
        'end_time',
        'reminders_scheduled_at',
        'session_day_10am_reminded_at',
        'one_hour_before_reminded_at',
        'ten_minutes_before_reminded_at',
    ];

    protected $casts = [
        'session_date' => 'date',
        'reminders_scheduled_at' => 'datetime',
        'session_day_10am_reminded_at' => 'datetime',
        'one_hour_before_reminded_at' => 'datetime',
        'ten_minutes_before_reminded_at' => 'datetime',
    ];

    public function courseStudent()
    {
        return $this->belongsTo(CourseStudent::class, 'course_student_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function schedule()
    {
        return $this->belongsTo(StaffScheduled::class, 'staff_scheduled_id');
    }

    public function session()
    {
        return $this->belongsTo(ScheduledSession::class, 'scheduled_session_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
