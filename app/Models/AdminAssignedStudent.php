<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdminAssignedStudent extends Model
{
    protected $table = "admin_assigned_students";
    protected $fillable = [
        'student_id',
        'admin_id',
        'staff_scheduled_id'
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function staffScheduled()
    {
        return $this->belongsTo(StaffScheduled::class, 'staff_scheduled_id');
    }
}
