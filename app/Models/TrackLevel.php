<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackLevel extends Model
{
    protected $table = 'track_levels';
    use HasFactory;
    protected $fillable = [
        'track_id',
        'name_en',
        'name_ar',
        'description_en',
        'description_ar',
        'file',
    ];

    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id')->withDefault();
    }

    public function track_level_sessions()
    {
        return $this->hasMany(TrackLevelSession::class, 'level_id', 'id');
    }
}
