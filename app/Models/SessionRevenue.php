<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionRevenue extends Model
{
    protected $table = 'session_revenues';

    protected $fillable = [
        'student_prepaid_id',
        'session_id',
        'session_amount',
        'total_amount',
        'remaining_before',
        'remaining_after',
        'used_sessions',
        'progress_amount',
    ];

    public function student_prepaid()
    {
        return $this->belongsTo(StudentPrepaid::class, 'student_prepaid_id');
    }

    public function session()
    {
        return $this->belongsTo(ScheduledSession::class, 'session_id');
    }
}
