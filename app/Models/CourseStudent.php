<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CourseStudent extends Model
{
    protected $table = 'course_students';

    protected $fillable = [
        'course_id',
        'student_id',
        'package_id',
        'finanace_student_invoice_id',
        'added_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function staffScheduleds()
    {
        return $this->belongsTo(StaffScheduled::class, 'course_id');
    }

    public function finanaceStudentInvoice()
    {
        return $this->belongsTo(FinanaceStudentInvoice::class, 'finanace_student_invoice_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
