<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RevenueRecognition extends Model
{
    protected $fillable = [
        'student_invoice_id',
        'source_service',
        'external_booking_reference',
        'external_session_reference',
        'recognized_amount',
        'currency',
        'recognized_at',
        'completed_at',
        'journal_entry_id',
        'idempotency_key',
    ];

    protected $casts = [
        'recognized_amount' => 'decimal:2',
        'recognized_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function studentInvoice()
    {
        return $this->belongsTo(StudentInvoice::class, 'student_invoice_id');
    }

    public function journalEntry()
    {
        return $this->belongsTo(JournalEntry::class);
    }
}
