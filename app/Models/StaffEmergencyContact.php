<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffEmergencyContact extends Model
{
    protected $table = 'staff_emergency_contact';

    protected $fillable = [
        'emergency_name',
        'emergency_relationship',
        'emergency_mobile',
        'emergency_home_telephone',
        'emergency_work_telephone',
        'staff_id',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }
    
}
