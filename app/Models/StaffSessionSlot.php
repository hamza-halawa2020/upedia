<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffSessionSlot extends Model
{
    protected $table = 'staff_session_slots';

    protected $fillable = [
        'staff_id',
        'created_by',
        'session_title',
        'date',
        'start_time',
        'end_time',
        'status',  //'induction','training','rejected','rescheduling','pending','scheduled','no-show'
        'link',
        'scheduled_by',
        'scheduled_at',
        'is_private',
        'session_type', // demo, training, induction
 
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
    public function scheduledBy()
    {
        return $this->belongsTo(User::class, 'scheduled_by');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function inductionTrainingStaff()
    {
        return $this->hasMany(InductionTrainingStaff::class, 'staff_session_slot_id');
    }
    public function applicants()
    {
        return $this->belongsToMany(Applicant::class, 'applicant_staff_session_slot', 'staff_session_slot_id', 'applicant_id')->withPivot('note');
    }
}
