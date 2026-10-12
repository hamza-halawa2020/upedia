<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreQuestion extends Model
{
    protected $table = 'score_questions';
    protected $fillable = [
        'section_id',
        'question_text',
        'full_score',
        'details'
    ];

    public function section()
    {
        return $this->belongsTo(ScoreSection::class,'section_id');
    }

    public function answers()
    {
        return $this->hasMany(ScoreAnswer::class,'question_id');
    }
}
