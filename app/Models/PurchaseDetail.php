<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseDetail extends Model
{
    protected $guarded = [];
    public function purchase()
    {
        return $this->belongsTo(Purchase::class, 'purchase_id');
    }

    public function booking()
    {
        return $this->belongsTo(CourseStudent::class, 'booking_id');
    }

    public function course()
    {
        return $this->belongsTo(StaffScheduled::class, 'course_id');
    }

    public function studentInvoice()
    {
        return $this->belongsTo(StudentInvoice::class, 'student_invoice_id');
    }
}
