<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $table = 'sm_add_incomes';

    protected $fillable = [
        'name',
        'date',
        'amount',
        'file',
        'description',
        'created_by',
        'payroll_payment_id',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function payrollPayment()
    {
        return $this->belongsTo(PayrollPayment::class, 'payroll_payment_id');
    }
}
