<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrRequestResignation extends Model
{
    protected $table = "hr_request_resignations";
    protected $fillable = [
        'resignation_date',
        'staff_id',
        'reason',
        'reason_type',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function hrRequest()
    {
        return $this->morphOne(HrRequest::class, 'reference');
    }

    public function hrTask()
    {
        return $this->morphOne(Task::class, 'reference');
    }
}
