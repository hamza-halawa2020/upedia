<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\FinanaceStudentInvoice;

class FrozenStudentSession extends Model
{

    protected $table = 'frozen_student_sessions';

    protected $fillable = [
        'student_id',
        'staff_scheduled_id',
        'session_number',
        'session_date',
        'start_time',
        'end_time',
        'staff_id',
        'staff_slot_id',
        'track_session_id',
        'request_id',
        'invoice_id',
        'is_paid',
        'payment_status',
    ];

    public function invoice()
    {
        return $this->belongsTo(FinanaceStudentInvoice::class, 'invoice_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function course()
    {
        return $this->belongsTo(StaffScheduled::class, 'staff_scheduled_id');
    }

    public function request()
    {
        return $this->belongsTo(StudentRequest::class, 'request_id');
    }
}
