<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollFinanceSync extends Model
{
    protected $fillable = [
        'payroll_run_id',
        'external_journal_entry_id',
        'sync_status',
        'synced_at',
        'last_sync_error',
        'finance_options',
    ];

    protected $casts = [
        'synced_at' => 'datetime',
        'finance_options' => 'array',
    ];

    public function payrollRun(): BelongsTo
    {
        return $this->belongsTo(PayrollRun::class);
    }
}
