<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SlotEmp extends Model
{
    use HasFactory;

    protected $fillable = [
        'slot_day',
        'slot_start',
        'slot_end',
    ];

    public function scheduledSlots()
    {
        return $this->hasMany(ScheduledSlot::class, 'slot_emp_id');
    }

    // Define the relationship with StaffSlot
    public function staffSlots()
    {
        return $this->hasMany(StaffSlot::class, 'slot_id'); // Assuming 'slot_id' is the foreign key in staff_slots
    }
}
