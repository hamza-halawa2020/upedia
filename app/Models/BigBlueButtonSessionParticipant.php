<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BigBlueButtonSessionParticipant extends Model
{
    protected $table = 'bbb_session_participants';

    protected $fillable = [
        'scheduled_session_id',
        'user_id',
        'bbb_user_id',
        'display_name',
        'role',
        'profile_type',
        'first_joined_at',
        'last_joined_at',
        'last_seen_at',
        'left_at',
        'attendance_total_seconds',
        'join_count',
        'is_online',
        'is_presenter',
        'is_listening_only',
        'has_joined_voice',
        'has_video',
        'mic_opened_at',
        'mic_closed_at',
        'mic_total_seconds',
        'mic_open_count',
        'mic_is_muted',
        'mic_muted_at',
        'mic_unmuted_at',
        'mic_events',
        'webcam_opened_at',
        'webcam_closed_at',
        'webcam_total_seconds',
        'webcam_open_count',
        'webcam_stream_id',
        'webcam_active_streams',
        'webcam_events',
        'raw_attendee',
    ];

    protected $casts = [
        'first_joined_at' => 'datetime',
        'last_joined_at' => 'datetime',
        'last_seen_at' => 'datetime',
        'left_at' => 'datetime',
        'attendance_total_seconds' => 'integer',
        'join_count' => 'integer',
        'is_online' => 'boolean',
        'is_presenter' => 'boolean',
        'is_listening_only' => 'boolean',
        'has_joined_voice' => 'boolean',
        'has_video' => 'boolean',
        'mic_opened_at' => 'datetime',
        'mic_closed_at' => 'datetime',
        'mic_total_seconds' => 'integer',
        'mic_open_count' => 'integer',
        'mic_is_muted' => 'boolean',
        'mic_muted_at' => 'datetime',
        'mic_unmuted_at' => 'datetime',
        'mic_events' => 'array',
        'webcam_opened_at' => 'datetime',
        'webcam_closed_at' => 'datetime',
        'webcam_total_seconds' => 'integer',
        'webcam_open_count' => 'integer',
        'webcam_active_streams' => 'array',
        'webcam_events' => 'array',
        'raw_attendee' => 'array',
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
