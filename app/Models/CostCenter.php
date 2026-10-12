<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CostCenter extends Model
{
    use HasFactory;

    protected $table = 'cost_centers';

    protected $fillable = [
        'code',
        'title',
        'slug',
        'parent_id',
        'status',
        'revenue_account_id',
        'expense_account_id',
        'created_by',
    ];

    public function parent()
    {
        return $this->belongsTo(CostCenter::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(CostCenter::class, 'parent_id');
    }

    public function childrenRecursive()
    {
        return $this->children()->with('childrenRecursive');
    }

    public function revenueAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'revenue_account_id');
    }

    public function expenseAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'expense_account_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }


    public function teamLeader() {
        return $this->belongsTo(Staff::class, 'team_leader_id');

    }


    public function journalLines()
    {
        return $this->hasMany(JournalEntryLine::class, 'cost_center_id');
    }

}
