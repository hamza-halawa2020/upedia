<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSubmission extends Model
{
    use HasFactory;

    protected $table = 'exam_exam_submissions';


    protected $fillable = [
        'user_id',
        'exam_id',
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

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
