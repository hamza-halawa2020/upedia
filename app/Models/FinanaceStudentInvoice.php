<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinanaceStudentInvoice extends Model
{
    use HasFactory;

    protected $table = 'finanace_student_invoices';

    protected $fillable = [
        'student_id',
        'invoice_number',
        'levels_id',
        'payment_status',
        'bill_status',
        'delivery_note',
        'type',
        'product_id',
        'package_id',
        'track_pricing_plan_id',
        'total_package_price',
        'level_count',
        'promocode_id',
        'discount_type',
        'discount',
        'net_price',
        'total_price',
        'deposite',
        'referral_activity_id',
        'referral_activity_type',
        'referral_activity_price',
        'staff_scheduleds_id',
        'track_type_id',
        'source_service',
        'external_booking_reference',
        'external_schedule_reference',
        'external_student_reference',
        'external_course_reference',
        'external_course_name',
        'external_student_name',
        'currency',
        'sessions_count',
        'registration_type',
        'sales_order_id',
        'sales_order_reference',
        'invoice_journal_entry_id',
        'finance_status',
        'created_by',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function productInvoice()
    {
        return $this->belongsTo(AcademyProduct::class, 'product_id');
    }

    public function trackInvoice()
    {
        return $this->belongsTo(Track::class, 'product_id');
    }

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function Transaction()
    {
        return $this->hasOne(Transaction::class, 'invoice_id');
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class, 'invoice_id');
    }

    public function promocode()
    {
        return $this->belongsTo(Promocode::class, 'promocode_id');
    }

    public function referralActivity()
    {
        return $this->belongsTo(Referralactivity::class, 'referral_activity_id');
    }

    // Attachment Relation
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable', 'model_type', 'model_id');
    }

    public function courseStudentInvoices()
    {
        return $this->hasMany(CourseStudent::class, 'finanace_student_invoice_id');
    }

    public function staff_scheduled()
    {
        return $this->belongsTo(StaffScheduled::class, 'staff_scheduleds_id');
    }

    public function consumeReferralActivityIfPaid(): void
    {
        if ($this->payment_status !== 'paid' || ! $this->referral_activity_id) {
            return;
        }

        $referralActivity = $this->referralActivity;
        $student = $this->student;

        if (! $referralActivity || ! $student) {
            return;
        }

        if ($this->isReferredReferralActivity($referralActivity, $student) && $referralActivity->referred_discount_used_at === null) {
            $referralActivity->update(['referred_discount_used_at' => now()]);

            return;
        }

        if ($this->isReferrerReferralActivity($referralActivity, $student) && $referralActivity->is_used == '0') {
            $referralActivity->update(['is_used' => '1']);
        }
    }

    private function isReferredReferralActivity(Referralactivity $referralActivity, Student $student): bool
    {
        return ($student->user_id && (int) $referralActivity->referredable_id === (int) $student->user_id && $referralActivity->referredable_type === User::class)
            || ((int) $referralActivity->referredable_id === (int) $student->id && $referralActivity->referredable_type === Student::class);
    }

    private function isReferrerReferralActivity(Referralactivity $referralActivity, Student $student): bool
    {
        return ($student->user_id && (int) $referralActivity->userable_id === (int) $student->user_id && $referralActivity->userable_type === User::class)
            || ((int) $referralActivity->userable_id === (int) $student->id && $referralActivity->userable_type === Student::class);
    }
}
