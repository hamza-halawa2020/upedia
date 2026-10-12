<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAssignmentAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_student_id',
        'assignment_id',
        'assigned_by',
        'assigned_at',
        'available_from',
        'available_until',
        'status',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
        'available_from' => 'datetime',
        'available_until' => 'datetime',
    ];

    public function courseStudent()
    {
        return $this->belongsTo(CourseStudent::class, 'course_student_id');
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

    public function sessionAssignment()
    {
        return $this->belongsTo(SessionAssignment::class, 'assignment_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }
}
