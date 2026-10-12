<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BookingRequest extends Model
{
    protected $table = 'crm_booking_requests';

    protected $fillable = [
        'type',
        'student_id',
        'date',
        'notes',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }
}
