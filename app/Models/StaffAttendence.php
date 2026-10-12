<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffAttendence extends Model
{
    use HasFactory;

    protected $table = "sm_staff_attendences";

    protected $fillable = [
       'attendence_type',   //  $table->string('attendence_type', 10)->nullable()->comment('Present: P Late: L Absent: A Holiday: H Half Day: F');
        'notes',
        'attendence_date',
        'staff_id',
        'created_by',
        'updated_by',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

}
