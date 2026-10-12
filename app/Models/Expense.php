<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $table = 'sm_add_expenses';

    protected $fillable = [
        'name',
        'date',
        'amount',
        'file',
        'description',
        'created_by',
        'payroll_payment_id',
        'expense_head_id',
        'treasury_id',
        'cost_center_id',
        'journal_entry_id',
        'posting_status',
        'transaction_type',
    ];
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function expenseHead()
    {
        return $this->belongsTo(ExpenseHead::class, 'expense_head_id');
    }
    public function payrollPayment()
    {
        return $this->belongsTo(PayrollPayment::class, 'payroll_payment_id');
    }

    public function journalEntry()
    {
        return $this->belongsTo(JournalEntry::class, 'journal_entry_id');
    }

    public function treasury()
    {
        return $this->belongsTo(Treasury::class, 'treasury_id');
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }
}
