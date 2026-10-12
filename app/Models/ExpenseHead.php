<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExpenseHead extends Model
{
    protected $table = 'sm_expense_heads';
    protected $fillable = [
        'name',
        'description',
        'created_by',
    ];
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function expenses()
    {
        return $this->hasMany(Expense::class, 'expense_head_id');
    }
}