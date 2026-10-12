<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InductionTrainingStaff extends Model
{
    protected $table = 'induction_training_staff';
    protected $fillable = [
        'staff_id',
        'staff_session_slot_id',
        'created_by',
        'session_number',
        'status',   // induction, pending, training, canceled
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function staffSessionSlot()
    {
        return $this->belongsTo(StaffSessionSlot::class, 'staff_session_slot_id');
    }
}
