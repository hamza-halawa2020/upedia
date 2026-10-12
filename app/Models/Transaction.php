<?php

namespace App\Models;

use Carbon\Carbon;

class Transaction extends CrmModel
{

    protected $appends = ['is_expired'];
    protected $guarded = [];
    protected $casts = [
        'gateway_payload' => 'array',
    ];

    public function invoice()
    {
        return $this->belongsTo(FinanaceStudentInvoice::class, 'invoice_id');
    }
    public function isExpired(): bool
    {
        return $this->expire_at && Carbon::now()->greaterThan(Carbon::parse($this->expire_at));
    }

    public function getIsExpiredAttribute(): bool
    {
        return $this->isExpired();
    }

    public function user()
    {
        return $this->belongsTo(Transaction::class, 'user_id');
    }
}
