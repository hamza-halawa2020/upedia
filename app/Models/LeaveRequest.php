<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveRequest extends Model
{
    use HasFactory;

    protected $table = 'sm_leave_requests';
    protected $fillable = [
        'apply_date',
        'leave_from',
        'leave_to',
        'reason',
        'note',
        'approve_status', // P for Pending, A for Approve, R for reject
        'leave_define_id',
        'staff_id',
        'role_id',
        'type_id',
        'created_by',
        'updated_by',
        'active_status',
    ];

    public function leaveDefine()
    {
        return $this->belongsTo(LeaveDefine::class, 'leave_define_id');
    }

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public function staff()
{
    return $this->belongsTo(User::class, 'staff_id');
}


    public function type()
    {
        return $this->belongsTo(LeaveType::class, 'type_id');
    }

    public function getApproveStatusTextAttribute()
{
    return match($this->approve_status) {
        'P' => 'Pending',
        'A' => 'Approved',
        'R' => 'Rejected',
        default => 'Unknown',
    };
}

}
