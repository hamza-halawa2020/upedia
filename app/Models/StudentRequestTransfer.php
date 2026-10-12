<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentRequestTransfer extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'student_request_id',
        'from_department_id',
        'to_department_id',
        'transferred_by',
        'status',
        'note',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function studentRequest()
    {
        return $this->belongsTo(StudentRequest::class);
    }

    public function fromDepartment()
    {
        return $this->belongsTo(SmHumanDepartment::class, 'from_department_id');
    }

    public function toDepartment()
    {
        return $this->belongsTo(SmHumanDepartment::class, 'to_department_id');
    }

    public function transferredBy()
    {
        return $this->belongsTo(User::class, 'transferred_by');
    }
}
