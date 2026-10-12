<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ScoreReportDemo extends Model
{
    protected $table = 'score_report_demos';
    protected $fillable = [
        'tester_id',
        'schedule_id',
        'academic_id',
        'result',
        'comment',
    ];
    public function tester()
    {
        return $this->belongsTo(Staff::class, 'tester_id');
    }
    public function schedule()
    {
        return $this->belongsTo(StaffScheduled::class, 'schedule_id');
    }
    public function academic()
    {
        return $this->belongsTo(User::class, 'academic_id');
    }
}
