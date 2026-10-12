<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuizSchedule extends Model
{
    use HasFactory;

    protected $table = 'exam_quiz_schedules';

    protected $fillable = [
        'quiz_id',
        'staff_scheduled_id',
        'start_date',
        'start_time',
        'end_date',
        'end_time',
        'grace_period',
        'schedule_type'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function quiz()
    {
        return $this->belongsTo(Quiz::class, 'quiz_id');
    }
      public function staffScheduled()
    {
        return $this->belongsTo(StaffScheduled::class, 'staff_scheduled_id');
    }
}
