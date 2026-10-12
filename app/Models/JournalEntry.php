<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class JournalEntry extends Model
{
    use HasFactory;

    protected $fillable = [
        'date',
        'description',
        'party_name',
        'party_type',
        'party_id',
        'party_ref',
        'type',
        'reference_no',
        'student_invoice_id',
        'source_service',
        'source_type',
        'source_id',
        'business_operation',
        'business_reference',
        'idempotency_key',
        'status',
        'posted_at',
        'created_by',
    ];

    protected $casts = [
        'date' => 'date',
        'posted_at' => 'datetime',
    ];

    public function lines()
    {
        return $this->hasMany(JournalEntryLine::class);
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function studentInvoice()
    {
        return $this->belongsTo(StudentInvoice::class, 'student_invoice_id');
    }

    public function payment()
    {
        return $this->hasOne(Payment::class, 'journal_entry_id')->latestOfMany();
    }
}
