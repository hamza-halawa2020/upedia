<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequestExperienceLetter extends Model
{
    protected $table = 'request_experience_letters';
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