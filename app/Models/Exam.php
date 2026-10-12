<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Exam extends Model
{
    use HasFactory;

    protected $table = 'exam_exams'; // Ensure this matches your table name

    protected $fillable = [
        'title',
        'description',
        'is_active',
        'total_marks',
        'total_duration',
        'total_questions',
        'settings',
        'track_level_id',
        'created_by',
        'exam_type',
        'pre_days_duration',
        'total_correct_marks',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'settings' => 'array',
        'pre_days_duration' => 'integer',
    ];

    public function examSubmissions()
    {
        return $this->hasMany(ExamSubmission::class, 'exam_id');
    }

    public function studentExamAssignments()
    {
        return $this->hasMany(StudentExamAssignment::class, 'exam_id');
    }

    public function schedules()
    {
        return $this->hasMany(ExamSchedule::class, 'exam_id');
    }

    public function examQuestions()
    {
        return $this->hasMany(ExamQuestion::class);
    }

    public function questions()
    {
        return $this->belongsToMany(Question::class, 'exam_exam_questions')
            ->withPivot('marks')
            ->withTimestamps();
    }

    public function track_level()
    {
        return $this->belongsTo(TrackLevel::class, 'track_level_id');
    }

    public function scopePast($query)
    {
        return $query->whereHas('schedules', function ($q) {
            $q->whereRaw("STR_TO_DATE(CONCAT(start_date, ' ', start_time), '%Y-%m-%d %H:%i:%s') < NOW()");
        });
    }

    public function attempts()
    {
        return $this->hasMany(ExamAttempt::class, 'exam_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
