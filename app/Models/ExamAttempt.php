<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $table = 'exam_exam_attempts';

    protected $fillable = [
        'user_id',
        'exam_id',
        'started_at',
        'ended_at',
        'status',   // in_progress, submitted, forbidden
    ];

    public function exams()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }

    public function users()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
