<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestHrLetter extends Model
{
    protected $table = 'hr_request_hr_letters';
    protected $fillable = [
        'staff_id',
        'reason_of_request',
        'request_type',
        'date_of_request',
        'letter_language',
        'additional_information',
        'attachment',
    ];
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
