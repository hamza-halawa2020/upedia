<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Urgent extends Model
{
    protected $table = 'urgents';
    protected $fillable = [
        'message',
        'student_id',
        'teacher_id',
        'scheduled_id',
        'session_id',
        'created_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class,'student_id');
    }

    public function teacher()
    {
        return $this->belongsTo(Staff::class,'teacher_id');
    }

    public function scheduled()
    {
        return $this->belongsTo(StaffScheduled::class,'scheduled_id');
    }

    public function session()
    {
        return $this->belongsTo(ScheduledSession::class,'session_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by');
    }
}
