<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffSlot extends Model
{
    use HasFactory;
    protected $table = 'staff_slots';

    protected $fillable = [
        'staff_id',
        'slot_id',
        'added_by'
    ];
    public function slotEmp()
    {
        return $this->belongsTo(SlotEmp::class, 'slot_id'); // 'slot_id' is the foreign key
    }
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id'); // 'staff_id' is the foreign key
    }
}
