<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollEarnDeduc extends Model
{
    use HasFactory;

    protected $table = 'sm_hr_payroll_earn_deducs';
    protected $fillable = [
        'type_name',
        'amount',
        'earn_dedc_type',   // $table->string('earn_dedc_type')->length(5)->nullable()->comment('e for earnings and d for deductions');
        'payroll_generate_id',
    ];

    public function payrollGenerate()
    {
        return $this->belongsTo(PayrollGenerate::class, 'payroll_generate_id');
    }
}
