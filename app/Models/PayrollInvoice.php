<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollInvoice extends Model
{
    protected $table = 'hr_payroll_invoices';

    protected $fillable = [
        'invoice_no',
        'month',
        'year',
        'total',
        'created_by',
    ];

    public function payrollGenerates()
    {
        return $this->hasMany(PayrollGenerate::class, 'payroll_invoice_id');
    }
}
