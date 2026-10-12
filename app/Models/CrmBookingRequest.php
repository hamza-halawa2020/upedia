<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmBookingRequest extends Model
{
    use HasFactory;
    protected $table = 'crm_booking_requests';

    public function student()
    {
        return $this->belongsTo(Student::class);
    }
}
