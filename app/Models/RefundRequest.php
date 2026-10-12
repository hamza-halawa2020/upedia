<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundRequest extends Model
{
    use HasFactory;

    protected $table = 'student_requests';

    protected $guarded = [];

    protected $casts = [
        'deduct_administrative_expenses' => 'boolean',
        'additional_refund_amount' => 'decimal:2',
        'refund_invoice_amount' => 'decimal:2',
        'refund_amount' => 'decimal:2',
        'package_level_deduction_amount' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'created_by');
    }

    public function course()
    {
        return $this->belongsTo(StaffScheduled::class, 'course_id');
    }

    public function histories()
    {
        return $this->hasMany(RefundRequestHistory::class, 'student_request_id')->latest();
    }

    public function getDeductAdminExpensesAttribute(): bool
    {
        return (bool) $this->deduct_administrative_expenses;
    }

    public function setDeductAdminExpensesAttribute($value): void
    {
        $this->attributes['deduct_administrative_expenses'] = (bool) $value;
    }

    public function getAdditionalAmountAttribute(): string
    {
        return (string) ($this->additional_refund_amount ?? '0.00');
    }

    public function setAdditionalAmountAttribute($value): void
    {
        $this->attributes['additional_refund_amount'] = $value ?? 0;
    }
}
