<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PayrollPayment extends Model
{
    use HasFactory;

    protected $table = 'payroll_payments';
    protected $fillable = [
        'sm_hr_payroll_generate_id',
        'amount',
        'payment_mode',   
        'payment_method_id',
        'payment_date',
        'bank_id',
        'note',
        'created_by',
    ];

    public function payrollGenerate()
    {
        return $this->belongsTo(PayrollGenerate::class, 'sm_hr_payroll_generate_id');
    }
}
