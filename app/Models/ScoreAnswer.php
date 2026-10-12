<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreAnswer extends Model
{
    protected $table = 'score_answers';
    protected $fillable = [
        'report_id',
        'question_id',
        'score',
        'note',
    ];

    protected $casts = [
        'score' => 'float',
    ];

    public function report()
    {
        return $this->belongsTo(ScoreReport::class,'report_id');
    }

    public function question()
    {
        return $this->belongsTo(ScoreQuestion::class,'question_id');
    }
}
