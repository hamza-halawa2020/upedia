<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class StudentInvoice extends Model
{
    use HasFactory;

    protected $table = 'finanace_student_invoices';

    protected $fillable = [
        'student_id',
        'invoice_number',
        'package_id',
        'track_pricing_plan_id',
        'total_package_price',
        'level_price',
        'level_count',
        'levels_count',
        'reserved_level_ids',
        'levels_id',
        'payment_status',
        'delivery_note',
        'type',
        'product_id',
        'promocode_id',
        'promocode_type',
        'promocode_price',
        'discount_plan_id',
        'discount_plan_type',
        'discount_plan_price',
        'net_price',
        'total_price',
        'apply_vat',
        'vat_rate',
        'vat_amount',
        'deposite',
        'payment_type',
        'invoice_img',
        'created_by',
        'source_service',
        'external_booking_reference',
        'external_schedule_reference',
        'external_student_reference',
        'external_course_reference',
        'external_course_name',
        'external_student_name',
        'currency',
        'sessions_count',
        'original_amount',
        'discount_amount',
        'final_amount',
        'registration_type',
        'invoice_journal_entry_id',
        'sales_order_id',
        'cost_center_id',
        'cancelled_at',
        'voided_at',
    ];

    protected $casts = [
        'net_price' => 'decimal:2',
        'total_price' => 'decimal:2',
        'apply_vat' => 'boolean',
        'vat_rate' => 'decimal:2',
        'vat_amount' => 'decimal:2',
        'original_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'final_amount' => 'decimal:2',
        'cancelled_at' => 'datetime',
        'voided_at' => 'datetime',
        'reserved_level_ids' => 'array',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function level()
    {
        return $this->belongsTo(TrackLevel::class, 'levels_id');
    }

     public function staffScheduleds()
    {
        return $this->hasMany(StaffScheduled::class, 'invoice_id');
    }

    public function product()
    {
        return $this->belongsTo(AcademyProduct::class, 'product_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function trackPricingPlan()
    {
        return $this->belongsTo(TrackPricingPlan::class, 'track_pricing_plan_id');
    }
    public function track()
    {
        return $this->belongsTo(Track::class, 'product_id');
    }

    public function promocode()
    {
        return $this->belongsTo(Promocode::class, 'promocode_id');
    }

    public function discountPlan()
    {
        return $this->belongsTo(DiscountPlan::class, 'discount_plan_id');
    }

    public function transactions()
    {
        return $this->hasMany(CrmTransaction::class, 'invoice_id');
    }

    public function paymentAllocations()
    {
        return $this->morphMany(PaymentAllocation::class, 'allocatable');
    }

    public function journalEntries()
    {
        return $this->hasMany(JournalEntry::class, 'student_invoice_id');
    }

    public function invoiceJournalEntry()
    {
        return $this->belongsTo(JournalEntry::class, 'invoice_journal_entry_id');
    }

    public function salesOrder()
    {
        return $this->belongsTo(Purchase::class, 'sales_order_id');
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }

    public function revenueRecognitions()
    {
        return $this->hasMany(RevenueRecognition::class, 'student_invoice_id');
    }

    public function courseStudentInvoices()
    {
        return $this->hasMany(CourseStudent::class, 'finanace_student_invoice_id');
    }

    public function getDisplayCompletionStatusAttribute(): string
    {
        return $this->isFullyPaidForDisplay() && $this->lastSessionHasPassed()
            ? 'complete'
            : 'not_complete';
    }

    public function getDisplayCompletionStatusLabelAttribute(): string
    {
        return $this->display_completion_status === 'complete' ? 'Complete' : 'Not Complete';
    }

    public function getDisplayCompletionStatusClassAttribute(): string
    {
        return $this->display_completion_status === 'complete' ? 'success' : 'warning';
    }

    public function getDisplayLastSessionAtAttribute(): ?Carbon
    {
        return $this->lastSessionEndsAt();
    }

    private function isFullyPaidForDisplay(): bool
    {
        $invoiceTotal = round((float) ($this->final_amount ?: $this->net_price ?: $this->total_price ?: 0), 2);

        if ($invoiceTotal <= 0) {
            return false;
        }

        $paidByPayments = $this->paymentAllocations
            ->filter(fn ($allocation) => $allocation->payment?->status === 'posted')
            ->sum(fn ($allocation) => (float) $allocation->allocated_amount * ($allocation->is_reversal ? -1 : 1));

        if (round((float) $paidByPayments, 2) + 0.001 >= $invoiceTotal) {
            return true;
        }

        return in_array($this->payment_status, ['paid'], true);
    }

    private function lastSessionHasPassed(): bool
    {
        $lastSessionAt = $this->lastSessionEndsAt();

        return $lastSessionAt ? $lastSessionAt->lte(now()) : false;
    }

    private function lastSessionEndsAt(): ?Carbon
    {
        $sessions = $this->courseStudentInvoices
            ->pluck('course')
            ->filter()
            ->flatMap(fn ($course) => $course->scheduledSessions ?? collect())
            ->filter(fn ($session) => !empty($session->session_date))
            ->map(function ($session) {
                $date = Carbon::parse($session->session_date);
                $time = $session->end_time ?: $session->start_time;

                return $time
                    ? Carbon::parse($date->toDateString() . ' ' . $time)
                    : $date->endOfDay();
            });

        return $sessions->sortDesc()->first();
    }
}
