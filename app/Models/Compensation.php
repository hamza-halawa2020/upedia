<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Compensation extends Model
{
    protected $table = 'compensations';

    protected $fillable = [
        'rule_id',
        'user_id',
        'amount',
        'date',
        'rule_level_id',
        'batch_id',
        'penalty_type',
         'is_exceeded_rule_levels_count',
         "double_paid_day",
        "hr_holiday_staff_id",
        "staff_schedule_session_id",

    ];

    public $timestamps = true;

    public function employee()
    {
        return $this->belongsTo(User::class , 'user_id');
    }

    public function rule()
    {
        return $this->belongsTo(Rule::class);
    }

    public function scopeInCurrentPayRollPeriod($query)
    {
        return $query->whereBetween('created_at',  [now()->subMonth()->day(15),
            now()->day(14)])
            ->orWhereBetween('date',  [now()->subMonth()->day(15), now()->day(14)]);
    }


    public function ruleLevel()
    {
        return $this->belongsTo(HrRuleLevel::class , 'rule_level_id' , 'id');
    }


    public function hrHolidayStaff() {
        return $this->belongsTo(HrHolidayStaff::class);
    }

    public function getPayrollRunAttribute()
    {
        $targetDate = $this->date ?? $this->created_at;

        if (!$targetDate) {
            return null;
        }

        return PayrollRun::where('from_date', '<=', $targetDate)
            ->where('to_date', '>=', $targetDate)
            ->first();
    }

    public function getIsLockedAttribute()
    {
        return (bool) $this->payroll_run;
    }
}
