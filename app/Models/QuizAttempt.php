<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizAttempt extends Model
{
    use HasFactory;

    protected $table = 'exam_quiz_attempts';

    protected $fillable = [
        'user_id',
        'quiz_id',
        'started_at',
        'ended_at',
        'status',   // in_progress, submitted, forbidden
    ];

    public function quizzes()
    {
        return $this->belongsTo(Exam::class, 'quiz_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
