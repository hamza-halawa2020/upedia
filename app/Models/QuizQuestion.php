<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizQuestion extends Model
{
    use HasFactory;


    protected $table = 'exam_quiz_questions';

    protected $fillable = [
        'quiz_id',
        'question_id',
        'marks',
        'section_id',
    ];
    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }

    public function question()
    {
        return $this->belongsTo(Question::class, 'question_id');
    }
}
