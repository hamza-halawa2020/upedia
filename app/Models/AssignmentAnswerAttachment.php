<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentAnswerAttachment extends Model
{
    protected $fillable = ['file_answer', 'assignment_answer_id'];

    public function assignmentAnswer()
    {
        return $this->belongsTo(AssignmentAnswer::class, 'assignment_answer_id');
    }
}