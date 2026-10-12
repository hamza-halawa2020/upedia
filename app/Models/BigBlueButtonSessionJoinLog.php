<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BigBlueButtonSessionJoinLog extends Model
{
    protected $table = 'bbb_session_join_logs';

    protected $fillable = [
        'scheduled_session_id',
        'user_id',
        'bbb_user_id',
        'display_name',
        'role',
        'joined_at',
        'left_at',
        'duration_seconds',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'left_at' => 'datetime',
        'duration_seconds' => 'integer',
    ];

    public function scheduledSession()
    {
        return $this->belongsTo(ScheduledSession::class, 'scheduled_session_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
