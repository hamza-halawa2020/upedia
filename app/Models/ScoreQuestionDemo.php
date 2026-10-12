<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreQuestionDemo extends Model
{
    protected $table = 'score_question_demos';

    protected $fillable = [
        'question',
    ];
    public function answers()
    {
        return $this->hasMany(ScoreAnswerDemo::class, 'question_id');
    }
}
