<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Quiz extends Model
{
    use HasFactory;

    protected $table = 'exam_quizzes'; // Ensure this matches your table name

    protected $fillable = [
        'title',
        'description',
        'type',
        'is_active',
        'payment_type',
        'total_marks',
        'total_duration',
        'total_questions',
        'price',
        'points_required',
        'settings',
        'track_level_session_id',
        'source_quiz_id',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',

    ];

    public function quizSubmissions()
    {
        return $this->hasMany(QuizSubmission::class, 'quiz_id');
    }

    public function schedules()
    {
        return $this->hasMany(QuizSchedule::class, 'quiz_id');
    }

    public function quizQuestions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_quiz_questions')
            ->withPivot('marks')
            ->withTimestamps();
    }

    public function track_level_session()
    {
        return $this->belongsTo(TrackLevelSession::class, 'track_level_session_id');
    }

    public function sourceQuiz()
    {
        return $this->belongsTo(Quiz::class, 'source_quiz_id');
    }

    public function referencedQuizzes()
    {
        return $this->hasMany(Quiz::class, 'source_quiz_id');
    }

    public function getIsReferencedAttribute(): bool
    {
        return $this->source_quiz_id !== null;
    }

    public function scopePast($query)
    {
        return $query->whereHas('schedules', function ($q) {
            $q->whereRaw("STR_TO_DATE(CONCAT(start_date, ' ', start_time), '%Y-%m-%d %H:%i:%s') < NOW()");
        });
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class, 'quiz_id');
    }



}
