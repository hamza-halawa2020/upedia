<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreAnswerDemo extends Model
{
    protected $table = 'score_answer_demos';

    protected $fillable = [
        'report_id',
        'question_id',
        'score',
        'comments',
    ];

    public function report()
    {
        return $this->belongsTo(ScoreReportDemo::class, 'report_id');
    }

    public function question()
    {
        return $this->belongsTo(ScoreQuestionDemo::class, 'question_id');
    }
}
