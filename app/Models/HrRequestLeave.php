<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrRequestLeave extends Model
{

    protected $table = "hr_request_leaves";
    protected $fillable = [
        'leave_from',
        'leave_to',
        'staff_id',
        'leave_type_id',
        'leave_reason',
        'status',
        "days_count"
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}

