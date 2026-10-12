<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OngoingAssessment extends Model
{
    protected $fillable = [
        'student_id',
        'staff_scheduled_id',
        'track_id',
        'track_level_id',
        'attendance_percentage',
        'attendance_score',
        'participation_percentage',
        'participation_score',
        'assignment_percentage',
        'assignment_score',
        'total_score',
        'graded_by',
        'graded_at',
    ];

    protected $casts = [
        'attendance_percentage' => 'decimal:2',
        'attendance_score' => 'decimal:2',
        'participation_percentage' => 'decimal:2',
        'participation_score' => 'decimal:2',
        'assignment_percentage' => 'decimal:2',
        'assignment_score' => 'decimal:2',
        'total_score' => 'decimal:2',
        'graded_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function staffScheduled()
    {
        return $this->belongsTo(StaffScheduled::class, 'staff_scheduled_id');
    }

    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }

    public function trackLevel()
    {
        return $this->belongsTo(TrackLevel::class, 'track_level_id');
    }

    public function grader()
    {
        return $this->belongsTo(User::class, 'graded_by');
    }
}
