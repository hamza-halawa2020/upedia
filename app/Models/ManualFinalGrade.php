<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ManualFinalGrade extends Model
{
    protected $fillable = [
        'student_id',
        'staff_scheduled_id',
        'track_id',
        'track_level_id',
        'type',
        'grade_percentage',
        'weighted_score',
        'feedback',
        'graded_by',
        'graded_at',
    ];

    protected $casts = [
        'grade_percentage' => 'decimal:2',
        'weighted_score' => 'decimal:2',
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
