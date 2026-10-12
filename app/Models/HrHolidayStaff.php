<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class HrHolidayStaff extends Model
{
    protected $table = 'hr_holiday_staffs';

    protected $fillable = [
        'hr_request_id',
        'staff_id',
        'date',
        'holiday_id',
        'type', // holiday, work
        'hr_approval_status',
        'hr_rejection_reason',
    ];

    public function holiday()
    {
        return $this->belongsTo(Holiday::class, 'holiday_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function scopeApproved(Builder $query): Builder
    {
        return $query->where('hr_approval_status', 'approved');
    }
}
