<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Applicant extends Model
{
    protected $table = 'applicants';

    protected $fillable = [
        'recruitment_id',
        'created_by',
        'assigned_staff_id',
        'referral_id',
        'full_name',
        'email',
        'contact_number',
        'source',
        'qualifications',
        'years_of_experience',
        'interview_date',
        'resume',

        'current_status',           // new, rejected, hired, offer_rejected
        'screening_status',         // pending, done, rejected
        'phone_call_status',        // pending, done, rejected
        'shortlist_status',         // pending, done, rejected
        'demo_scheduling_status',   // pending, done, rejected
        'stage_status',             // induction, training, rejected, rescheduling, no-show
        'is_resheduled',
        'stage_result',             // passed, failed
        'final_interview_done',
        'offer_status',             // pending, done, rejected, no-show
        'offer_sent_at',
        'offer_decline_reason',
        'notes',
        'stage_note',

        'staff_id',
        'user_id',
        'offline_training',         //attended, not_attended
        'second_interview_done'
    ];

    protected $casts = [
        'interview_date' => 'date',
        'offer_sent_at' => 'datetime',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function candidateUser()
    {
        return $this->hasOne(User::class, 'applicant_id');
    }

    public function recruitment()
    {
        return $this->belongsTo(HrRequestRecruitment::class, 'recruitment_id');
    }

    public function assignedStaff()
    {
        return $this->belongsTo(Staff::class, 'assigned_staff_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function referral()
    {
        return $this->belongsTo(StaffReferral::class, 'referral_id');
    }

    public function staffSessionSlots()
    {
        return $this->belongsToMany(StaffSessionSlot::class, 'applicant_staff_session_slot', 'applicant_id', 'staff_session_slot_id')->withPivot('note');
    }
    public function logs()
    {
        return $this->hasMany(ApplicantLog::class, 'applicant_id')->latest();
    }

    public function isRejected()
    {
        return $this->current_status === 'rejected' || $this->offer_status === 'rejected';
    }

    public function isHired()
    {
        return $this->offer_status === 'accepted';
    }

    public static function reportConfig()
    {
        return [
            'label' => 'Applicants Report',
            'relations' => ['recruitment.category'],
            'fields' => [
                'recruitment.category.name' => 'Category',
            ],
            'filters' => [
                'current_status' => ['type' => 'select_static', 'options' => ['new' => 'New', 'hired' => 'Hired', 'rejected' => 'Rejected'], 'label' => 'Status'],
                'created_at' => ['type' => 'date_range', 'label' => 'Applied Date'],
            ]
        ];
    }
}
