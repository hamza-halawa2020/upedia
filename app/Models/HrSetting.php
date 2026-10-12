<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrSetting extends Model
{

    protected $table = 'hr_settings';
    protected $fillable = [
        'late_minutes',
        'shift_start_at',
        'shift_end_at',
        'allowed_period_to_pay_invoices',
        "attendence_start_at",
    ];

    public $timestamps = true;

}
