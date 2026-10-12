<?php

namespace Modules\IT\Expenses\Models;

use Illuminate\Database\Eloquent\Model;

class ItExpense extends Model
{
    protected $table = 'expenses';

    protected $fillable = [
        'amount',
        'payment_date',
        'due_date',
        'payment_method',
        'status',
        'item_name',
        'recurring',
        'vendors',
        'expense_head_id',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
        'due_date' => 'date',
    ];
}
