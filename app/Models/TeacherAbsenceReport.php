<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TeacherAbsenceReport extends Model
{
    protected $table = "teacher_absence_reports";

    protected $fillable = [
        'old_session_id',
        'teacher_id',
        'new_staff_scheduled_id',
        'created_by',
    ];

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id');
    }
    public function oldSession()
    {
        return $this->belongsTo(ScheduledSession::class, 'old_session_id');
    }
    public function StaffScheduled()
    {
        return $this->belongsTo(StaffScheduled::class, 'new_staff_scheduled_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
