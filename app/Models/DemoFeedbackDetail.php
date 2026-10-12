<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DemoFeedbackDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_feedback_id',
        'track_id',
        'level_id',
        'is_recommended',
        'note',
    ];

    protected $casts = [
        'is_recommended' => 'boolean',
    ];

    public function feedback()
    {
        return $this->belongsTo(TeacherFeedback::class, 'teacher_feedback_id');
    }

    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }

    public function level()
    {
        return $this->belongsTo(TrackLevel::class, 'level_id');
    }
}
