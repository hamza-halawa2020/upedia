<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSubmission extends Model
{
    use HasFactory;

    protected $table = 'exam_quiz_submissions';


    protected $fillable = [
        'student_quiz_assignment_id',
        'course_student_id',
        'user_id',
        'quiz_id',
        'answers',
        'total_time_seconds',
        'time_taken_seconds',
        'submitted_at',
        'total_marks',
        'score',
        'percentage',
        'passed',
        'accuracy'
    ];

    protected $casts = [
        'answers' => 'json',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function studentQuizAssignment()
    {
        return $this->belongsTo(StudentQuizAssignment::class, 'student_quiz_assignment_id');
    }

    public function courseStudent()
    {
        return $this->belongsTo(CourseStudent::class, 'course_student_id');
    }
}
