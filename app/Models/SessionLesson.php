<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionLesson extends Model
{
    use HasFactory;
    protected $fillable = [
        'session_id',
        'level_id',
        'name',
        'duration',
        'privacy',
        'description',
        'communicative_goal',
    ];


    public function session()
    {
        return $this->belongsTo(TrackLevelSession::class, 'session_id');
    }
    public function level()
    {
        return $this->belongsTo(TrackLevel::class, 'level_id');
    }

    public function assets()
    {
        return $this->hasMany(LessonAsset::class, 'lesson_id');
    }
}
