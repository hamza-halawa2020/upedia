<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentExamAssignment extends Model
{
    use HasFactory;

    protected $table = 'student_exam_assignments';

    protected $fillable = [
        'exam_id',
        'course_student_id',
        'assigned_at',
    ];

    protected $casts = [
        'assigned_at' => 'datetime',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function courseStudent()
    {
        return $this->belongsTo(CourseStudent::class, 'course_student_id');
    }


}
