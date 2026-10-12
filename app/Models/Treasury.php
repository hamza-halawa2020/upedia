<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Treasury extends Model
{
    use HasFactory;

    protected $table = 'treasuries';

    protected $fillable = [
        'name',
        'account_id',
        'type',
        'payment_flow',
        'payment_region',
        'is_payment_available',
        'iban',
        'bank_name',
        'account_number',
        'has_insta_pay',
        'insta_pay_phone',
        'opening_balance',
        'balance',
        'currency',
        'status',
        'is_active',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function transactions()
    {
        return $this->hasMany(TreasuryTransaction::class, 'treasury_id');
    }

    public function account()
    {
        return $this->belongsTo(ChartOfAccount::class, 'account_id');
    }

    public function linkedAccounts()
    {
        return $this->belongsToMany(
            ChartOfAccount::class,
            'treasury_account_links',
            'treasury_id',
            'account_id'
        )->withTimestamps();
    }

    public function hasTransactions()
    {
        return $this->transactions()->exists();
    }
}
