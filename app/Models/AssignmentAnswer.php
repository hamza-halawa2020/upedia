<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentAnswer extends Model
{
    protected $fillable = [
        'assignment_id',
        'student_id',
        'text',
        'type',
        'grade',
        'feedback',
        'graded_by',
        'graded_at',

    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class, 'assignment_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function answerAttachments()
    {
        return $this->hasMany(AssignmentAnswerAttachment::class, 'assignment_answer_id');
    }

    public function grader()
    {
        return $this->belongsTo(User::class, 'graded_by');
    }
}
