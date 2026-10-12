<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'exam_questions';


    protected $fillable = [
        'parent_question_id',
        'question_type_id',
        'question',
        'media_path',
        'media_type',
        'default_marks',
        'default_time',
        'requires_manual_grading',
        'category_id',
        'track_id',
        'level_id',
        'session_id',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'requires_manual_grading' => 'boolean',
    ];

    public function parentQuestion()
    {
        return $this->belongsTo(Question::class, 'parent_question_id');
    }

    public function childQuestions()
    {
        return $this->hasMany(Question::class, 'parent_question_id');
    }

    public function questionAnswers()
    {
        return $this->hasMany(QuestionAnswer::class);
    }

    public function questionType()
    {
        return $this->belongsTo(QuestionType::class, 'question_type_id');
    }

    public function level()
    {
        return $this->belongsTo(TrackLevel::class, 'level_id');
    }
    public function session()
    {
        return $this->belongsTo(TrackLevelSession::class, 'session_id');
    }
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }


    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class);
    }
    public function quizQuestions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function exams()
    {
        return $this->belongsToMany(Exam::class, 'exam_exam_quizzes')
            ->withTimestamps();
    }
    public function quizzes()
    {
        return $this->belongsToMany(Quiz::class, 'exam_quiz_questions')
            ->withTimestamps();
    }
}
