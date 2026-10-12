<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionQuiz extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'level_id',
        'title',
        'instruction',
        'min_percentage',
        'privacy',
    ];


    public function session()
    {
        return $this->belongsTo(TrackLevelSession::class, 'session_id');
    }
    public function level()
    {
        return $this->belongsTo(TrackLevel::class, 'level_id');
    }
}
