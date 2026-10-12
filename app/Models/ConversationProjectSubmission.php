<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ConversationProjectSubmission extends Model
{
    protected $fillable = [
        'student_id',
        'staff_scheduled_id',
        'exam_attempt_id',
        'uploaded_file_path',
        'pronunciation_intonation_score',
        'vocabulary_lexical_range_score',
        'fluency_cohesion_score',
        'grammar_syntax_score',
        'communication_strategies_score',
        'total_score',
        'weighted_score',
        'reviewed_by',
        'reviewed_at',
        'status',
    ];

    protected $casts = [
        'pronunciation_intonation_score' => 'decimal:2',
        'vocabulary_lexical_range_score' => 'decimal:2',
        'fluency_cohesion_score' => 'decimal:2',
        'grammar_syntax_score' => 'decimal:2',
        'communication_strategies_score' => 'decimal:2',
        'total_score' => 'decimal:2',
        'weighted_score' => 'decimal:2',
        'reviewed_at' => 'datetime',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function staffScheduled()
    {
        return $this->belongsTo(StaffScheduled::class, 'staff_scheduled_id');
    }

    public function examAttempt()
    {
        return $this->belongsTo(ExamAttempt::class, 'exam_attempt_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewed_by');
    }
}
