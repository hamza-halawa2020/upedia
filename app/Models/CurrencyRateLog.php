<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CurrencyRateLog extends Model
{
    protected $fillable = [
        'currency_rate_id',
        'currency',
        'old_rate',
        'new_rate',
        'old_default',
        'new_default',
        'updated_by',
    ];

    public function currencyRate()
    {
        return $this->belongsTo(CurrencyRate::class);
    }

    public function editor()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
