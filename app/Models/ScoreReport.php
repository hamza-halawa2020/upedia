<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreReport extends Model
{
    protected $table = 'score_reports';
    protected $fillable = [
        'teacher_id',
        'academic_id',
        'session_id',
        'schedule_id',
        'type'
    ];
    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id');
    }
    public function academic()
    {
        return $this->belongsTo(User::class, 'academic_id');
    }
    public function session()
    {
        return $this->belongsTo(ScheduledSession::class, 'session_id');
    }
    public function schedule()
    {
        return $this->belongsTo(StaffScheduled::class, 'schedule_id');
    }
    public function answers()
    {
        return $this->hasMany(ScoreAnswer::class,'report_id');
    }
}