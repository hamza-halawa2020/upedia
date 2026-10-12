<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShiftEmp extends Model
{
    protected $table = 'shift_emps';

    protected $fillable = [
        'name',
        'work_from',
        'work_to',
        'shift_type',
        'created_by',
    ];

    protected $casts = [
        'shift_type' => 'string',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function staffs()
    {
        return $this->hasMany(Staff::class, 'shift_emp_id');
    }
}
