<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public const DIRECTIONS = ['incoming', 'outgoing', 'transfer'];
    public const SOURCE_TYPES = ['manual', 'invoice', 'bill', 'refund', 'payroll', 'import', 'api'];
    public const STATUSES = ['draft', 'pending', 'posted', 'voided', 'reversed'];
    public const PARTY_TYPES = ['teacher', 'staff', 'student', 'company'];
    public const PAYMENT_METHODS = ['cash', 'bank_transfer', 'card', 'payment_gateway'];

    protected $fillable = [
        'payment_no',
        'payment_date',
        'direction',
        'source_type',
        'purchase_invoice_id',
        'treasury_id',
        'status',
        'amount',
        'currency',
        'payment_method',
        'cost_center_id',
        'from_account_id',
        'to_account_id',
        'party_type',
        'party_id',
        'party_name',
        'party_ref',
        'reference_no',
        'notes',
        'journal_entry_id',
        'posted_at',
        'reversed_payment_id',
        'reversal_reason',
        'idempotency_key',
        'source_service',
        'external_booking_reference',
        'external_transaction_reference',
        'payment_reference',
        'receipt_image',
        'approval_status',
        'approved_at',
        'approved_by',
        'rejected_at',
        'rejected_by',
        'rejection_reason',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'posted_at' => 'datetime',
        'approved_at' => 'datetime',
        'rejected_at' => 'datetime',
        'amount' => 'decimal:2',
    ];

    public function fromAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'from_account_id');
    }

    public function toAccount()
    {
        return $this->belongsTo(ChartOfAccount::class, 'to_account_id');
    }

    public function journalEntry()
    {
        return $this->belongsTo(JournalEntry::class, 'journal_entry_id');
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class);
    }

    public function treasury()
    {
        return $this->belongsTo(Treasury::class, 'treasury_id');
    }

    public function creator()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(Staff::class, 'updated_by');
    }

    public function allocations()
    {
        return $this->hasMany(PaymentAllocation::class);
    }

    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class, 'purchase_invoice_id');
    }

    public function reversedPayment()
    {
        return $this->belongsTo(self::class, 'reversed_payment_id');
    }

    public function reversePayments()
    {
        return $this->hasMany(self::class, 'reversed_payment_id');
    }

    public function getPartyLabelAttribute(): string
    {
        $reference = $this->party_ref ? " ({$this->party_ref})" : '';

        return trim((string) $this->party_name) . $reference;
    }
}
