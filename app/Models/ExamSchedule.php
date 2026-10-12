<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSchedule extends Model
{
    use HasFactory;

    protected $table = 'exam_exam_schedules';

    protected $fillable = [
        'exam_id',
        'staff_scheduled_id',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'grace_period',
        'schedule_type'
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function exam()
    {
        return $this->belongsTo(Exam::class, 'exam_id');
    }
    public function staffScheduled()
    {
        return $this->belongsTo(StaffScheduled::class, 'staff_scheduled_id');
    }


}
