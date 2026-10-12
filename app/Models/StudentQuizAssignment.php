<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentQuizAssignment extends Model
{
    use HasFactory;

    protected $table = 'student_quiz_assignments';

    protected $fillable = [
        'course_student_id',
        'quiz_id',
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

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function submissions()
    {
        return $this->hasMany(QuizSubmission::class, 'student_quiz_assignment_id');
    }
}
