<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffTargetConfigurationGroup extends Model
{
    protected $fillable = [
        'type',
        'created_by',
        'department_id',
        'job_title_id',
        'target_type',
        'percentage',
        'conv_min_percentage',
        'bonus_conv_percentage',
        'bonus_percentage',
        'quarter_target',
        'quarter_total_target',
        'quarter_days',
        'daily_target',
    ];

    public function configurations()
    {
        return $this->hasMany(StaffTargetConfiguration::class, 'group_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function department()
    {
        return $this->belongsTo(SmHumanDepartment::class, 'department_id');
    }

    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }
}
