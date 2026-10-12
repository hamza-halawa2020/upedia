<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CompensationLog extends Model
{
    protected $table = 'compensation_logs';

    protected $fillable = [
        'staff_id',
        'auth_id',
        'change_log',
        'month',
        'year',
        'from_date',
        'to_date',
    ];
    public function auth()
    {
        return $this->belongsTo(Staff::class, 'auth_id');
    }
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

}
