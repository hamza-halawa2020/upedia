<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class PayrollRun extends Model
{
    protected $table = 'payroll_runs';
    protected $fillable = [
        'from_date',
        'to_date',
        'month',
        'year',
        'run_at',
    ];

    public function payRollStaffs(): HasMany
    {
        return $this->hasMany(PayRollStaff::class, 'payroll_run_id');
    }

    public function financeSync(): HasOne
    {
        return $this->hasOne(PayrollFinanceSync::class, 'payroll_run_id');
    }
}
