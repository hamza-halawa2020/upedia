<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrRequestItTicket extends Model
{

     protected $table = "hr_request_it_tickets";
    protected $fillable = [
        'staff_id',
        'it_category',
        'it_sub_category',
        'it_item',
        'it_subject',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function hrRequest()
    {
        return $this->morphOne(HrRequest::class, 'reference');
    }

}

