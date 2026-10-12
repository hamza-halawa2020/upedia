<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScheduledSlot extends Model
{
    use HasFactory;

    protected $table = 'academy_scheduled_slots';
    protected $fillable = [
        'slot_day',
        'slot_start',
        'slot_end',
        'staff_scheduled_id',
        'slot_emp_id',
    ];

    public function staffScheduled()
    {
        return $this->belongsTo(StaffScheduled::class,'staff_scheduled_id');
    }

}