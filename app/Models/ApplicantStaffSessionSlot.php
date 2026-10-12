<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantStaffSessionSlot extends Model
{
    protected $table = 'applicant_staff_session_slot';

    protected $fillable = [
        'staff_session_slot_id',
        'applicant_id',
        'note',
    ];

    public function staffSessionSlots()
    {
        return $this->belongsTo(StaffSessionSlot::class, 'staff_session_slot_id');
    }
    public function applicant()
    {
        return $this->belongsTo(Applicant::class, 'applicant_id');
    }

}
