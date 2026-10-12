<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PerformaceReport extends Model
{
    protected $table = 'performace_reports';

    protected $fillable = [
        'schedule_id',
        'student_id',
        'teacher_id',
        'goals',
        'feedback',
        'listening',
        'reading',
        'speaking',
        'vocabulary',
        'grammar',
        'objectives', //json
    ];

    public function schedule()
    {
        return $this->belongsTo(StaffScheduled::class, 'schedule_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id');
    }
}
