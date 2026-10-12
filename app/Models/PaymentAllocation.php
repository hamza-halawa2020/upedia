<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentAllocation extends Model
{
    use HasFactory;

    protected $fillable = [
        'payment_id',
        'allocatable_type',
        'allocatable_id',
        'allocated_amount',
        'remaining_before',
        'remaining_after',
        'is_reversal',
        'notes',
    ];

    protected $casts = [
        'allocated_amount' => 'decimal:2',
        'remaining_before' => 'decimal:2',
        'remaining_after' => 'decimal:2',
        'is_reversal' => 'boolean',
    ];

    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }

    public function allocatable()
    {
        return $this->morphTo();
    }
}
