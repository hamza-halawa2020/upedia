<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffReferral extends Model
{
    protected $fillable = [
        'staff_id',
        'name',
        'phone',
        'job_title_id',
        'cv',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class);
    }

    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }
}
