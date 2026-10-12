<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherFeedback extends Model
{
    protected $table = 'teacher_feedback';

    protected $fillable = [
        'student_id',
        'teacher_id',
        'staff_schedule_id',
        'session_id',
        'type',
        'submission_status',
        'level',
        'need',
        'first_feedback',
        'result',
        'score',
        'up_to_level',
        'grammar',
        'speaking',
        'appropriacy',
        'listening',
        'reading',
        'writing',
        'teachers_note',
        'demo_grammar',
        'demo_speaking',
        'demo_appropriacy',
        'demo_listening',
        'demo_reading',
        'demo_writing',
        'suggested_levels',
        'suggested_band',
        'demo_vocabulary',
        'objectivies',
        'comment'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function staffScheduled()
    {
        return $this->belongsTo(StaffScheduled::class, 'staff_schedule_id');
    }
    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id');
    }
    public function session()
    {
        return $this->belongsTo(ScheduledSession::class, 'session_id');
    }

    public function demoFeedbackDetails()
    {
        return $this->hasMany(DemoFeedbackDetail::class, 'teacher_feedback_id');
    }
}
