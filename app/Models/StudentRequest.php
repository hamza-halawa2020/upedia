<?php

namespace App\Models;

use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class StudentRequest extends Model
{
    protected $table = 'student_requests';

    protected $fillable = 
    [
        'created_by',
        'created_by_admin_id',
        'assigned_to_admin_id',
        'assigned_to_department_id',
        'instructor_id',
        'supervisor_id',
        'type',
        'related_to',
        'activity_type',
        'date',
        'time',
        'change_time',
        'priority',
        'session',
        'subject',
        'description',
        'admin_id',
        'course_id',
        'session_id',
        'request_type_id',
        'status',
        'status_note',
        'refund_invoice_amount',
        'refund_package_name',
        'package_level_deduction_amount',
        'deduct_administrative_expenses',
        'additional_refund_amount',
        'refund_amount',
        'status_changed_by',
        'resolved_at',
        'closed_at',
    ];
    public function creator()
    {
        return $this->belongsTo(Student::class, 'created_by');
    }
    public function createdByAdmin()
    {
        return $this->belongsTo(User::class, 'created_by_admin_id');
    }
    public function assignedToAdmin()
    {
        return $this->belongsTo(User::class, 'assigned_to_admin_id');
    }
    public function assignedToStaff()
    {
        return $this->belongsTo(Staff::class, 'assigned_to_admin_id');
    }
    public function assignedToDepartment()
    {
        return $this->belongsTo(SmHumanDepartment::class, 'assigned_to_department_id');
    }
    public function instructor()
    {
        return $this->belongsTo(Staff::class, 'instructor_id');
    }
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable', 'model_type', 'model_id');
    }
    public function notes()
    {
        return $this->morphMany(Note::class, 'noteable');
    }
    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
    public function course()
    {
        return $this->belongsTo(StaffScheduled::class, 'course_id');
    }
    public function session()
    {
        return $this->belongsTo(ScheduledSession::class, 'session_id');
    }
    public function scheduledSession()
    {
        return $this->belongsTo(ScheduledSession::class, 'session_id');
    }
    public function statusChangedBy()
    {
        return $this->belongsTo(User::class, 'status_changed_by');
    }
    public function statusHistories()
    {
        return $this->hasMany(ComplaintStatusHistory::class, 'complaint_id')->latest('created_at');
    }
    protected static function booted()
    {
        static::creating(function ($student_request) {
            if (Auth::check() && empty($student_request->created_by)) {
                $student = Student::where('user_id', Auth::id())->first();

                if ($student) {
                    $student_request->created_by = $student->id;
                }
            }
        });
    }
}
