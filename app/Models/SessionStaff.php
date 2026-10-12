<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SessionStaff extends Model
{
    protected $table = 'academy_session_staffs';
    use HasFactory;
    protected $fillable = [
        'session_date',
        'track_level_session_id',
        'staff_id',
        'slot_id',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class,'staff_id');
    }

    public function trackLevelSession()
    {
        return $this->belongsTo(TrackLevelSession::class,'track_level_session_id');
    }
    public function slots()
    {
        return $this->belongsTo(SlotEmp::class,'slot_id');
    }
}
