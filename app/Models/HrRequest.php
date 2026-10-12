<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrRequest extends Model
{
    protected $table = 'hr_requests';

    protected $fillable = [
        'created_by',
        'department_id',
        'request_type_id',
        'priority',
        'deadline',
        'request_for',
        'details',
        'status',
        'notes',
        'reference_id',
        'reference_type',

    ];

    public function creator()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }

    public function requestFor()
    {
        return $this->belongsTo(Staff::class, 'request_for');
    }

    public function type()
    {
        return $this->belongsTo(HrRequestType::class, 'request_type_id');
    }

    public function department()
    {
        return $this->belongsTo(SmHumanDepartment::class, 'department_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable', 'model_type', 'model_id');
    }

    public function replies()
    {
        return $this->hasMany(Reply::class, 'request_id');
    }

    public function requestRecruitments()
    {
        return $this->hasMany(HrRequestRecruitment::class, 'request_id');
    }

    public function holidayStaffs()
    {
        return $this->hasMany(HrHolidayStaff::class, 'hr_request_id');
    }

    public function reference()
    {
        return $this->morphTo(__FUNCTION__, 'reference_type', 'reference_id');

    }
}
