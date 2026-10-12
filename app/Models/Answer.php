<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    use HasFactory, SoftDeletes;


    protected $table = 'exam_answers';

    protected $fillable = [
        'answer',
        'is_correct',
        'order_number',
    ];
    protected $casts = [
        'is_correct' => 'boolean',
    ];

    public function questionAnswers()
    {
        return $this->hasMany(QuestionAnswer::class);
    }
}
