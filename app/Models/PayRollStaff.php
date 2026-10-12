<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayRollStaff extends Model
{
    use HasFactory;

    protected $table = 'pay_roll_saffs';

    protected $fillable = [
        'payroll_run_id',
        'staff_id',
        'gross_salary',
        'net_salary',
        'penalties',
        'bonuses',
        'notes',
    ];

    public function payrollRun()
    {
        return $this->belongsTo(PayrollRun::class, 'payroll_run_id');
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
