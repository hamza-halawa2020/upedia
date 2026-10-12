<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAssignedTeacher extends Model
{

    protected $table = 'admin_assigned_teachers';
    protected $fillable = [
        'teacher_id',
        'admin_id',
        'track_type_id',
        'shift',
    ];

    public function teacher()
    {
        return $this->belongsTo(Staff::class, 'teacher_id');
    }

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }

    public function trackType()
    {
        return $this->belongsTo(TrackType::class, 'track_type_id');
    }
}
