<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveDefine extends Model
{
    use HasFactory;

    protected $table = 'sm_leave_defines';
    protected $fillable = [
        'days',
        'role_id',
        'user_id',
        'type_id',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function type()
    {
        return $this->belongsTo(LeaveType::class);
    }
}
