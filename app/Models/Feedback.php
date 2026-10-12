<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedback';

    protected $guarded = [];

    public function scheduledSession()
    {
        return $this->belongsTo(ScheduledSession::class, 'scheduled_session_id');
    }
    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
