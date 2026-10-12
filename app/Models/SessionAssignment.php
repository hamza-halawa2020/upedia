<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionAssignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'session_id',
        'level_id',
        'title',
        'marks',
        'min_percentage',
        'attachment',
        'submit_date',
        'description',
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

    public function tracks()
    {
        return $this->belongsToMany(Track::class, 'track_assigned_staff');
    }
}

