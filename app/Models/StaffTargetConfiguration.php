<?php

namespace App\Models;

use App\Models\SmHumanDepartment;
use Illuminate\Database\Eloquent\Model;

class StaffTargetConfiguration extends Model
{
    protected $table = 'staff_target_configurations';

    protected $fillable = [
        'group_id',
        'type',
        'created_by',
        'department_id',
        'job_title_id',
        'target_job_title_id',
        'target_type',
        'target_from',
        'target_to',
        'percentage',
        'conv_min_percentage',
        'bonus_conv_percentage',
        'bonus_percentage',
        'quarter_target',
        'quarter_total_target',
        'quarter_days',
        'daily_target',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function group()
    {
        return $this->belongsTo(StaffTargetConfigurationGroup::class, 'group_id');
    }

    public function department()
    {
        return $this->belongsTo(SmHumanDepartment::class, 'department_id');
    }

    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }

    public function targetJobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'target_job_title_id');
    }
}
