<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollGenerate extends Model
{
    use HasFactory;

    protected $table = 'sm_hr_payroll_generates';
    protected $fillable = [
        'basic_salary',
        'total_earning',
        'total_deduction',
        'gross_salary',
        'tax',
        'net_salary',
        'payroll_month',
        'payroll_year',
        'payroll_status',
        'payment_mode',
        'payment_date',
        'bank_id',
        'note',
        'active_status',
        'paid_amount',
        'is_partial',
        'staff_id',
        'created_by',
        'updated_by',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function payrollEarnDeducs()
    {
        return $this->hasMany(PayrollEarnDeduc::class);
    }

    public function payment()
    {
        return $this->hasOne(PayrollPayment::class, 'sm_hr_payroll_generate_id');
    }

    public function payrollInvoice()
    {
        return $this->belongsTo(PayrollInvoice::class, 'payroll_invoice_id');
    }
}
