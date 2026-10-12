<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentPrepaid extends Model
{
    protected $table = 'student_prepaids';

    protected $fillable = [
        'student_id',
        'staff_scheduled_id',
        'total_sessions',
        'remaining_sessions',
        'total_amount',
        'session_price',
    ];

    public function schedule()
    {
        return $this->belongsTo(StaffScheduled::class, 'staff_scheduled_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function revenues()
{
    return $this->hasMany(SessionRevenue::class, 'student_prepaid_id');
}

}
