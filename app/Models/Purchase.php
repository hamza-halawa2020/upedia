<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{

    protected $fillable = [
        'purchase_number',
        'invoice_type',
        'party_type',
        'student_id',
        'name',
        'required_by',
        'due_date',
        'expense_head_id',
        'cost_center_id',
        'status',
        'sub_total',
        'shipping_cost',
        'apply_vat',
        'vat_amount',
        'total',
        'source_service',
        'external_booking_reference',
        'external_schedule_reference',
        'external_student_reference',
        'external_course_reference',
        'student_invoice_id',
        'purchase_invoice_id',
    ];


    public function requestedStaffs()
    {
        return $this->belongsToMany(Staff::class, 'purchase_staff', 'purchase_id', 'staff_id');
    }
    public function details()
    {
        return $this->hasMany(PurchaseDetail::class, 'purchase_id');
    }
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable', 'model_type', 'model_id');
    }
    public function Vendors()
    {
        return $this->belongsToMany(Vendor::class, 'purchase_vendors', 'purchase_id', 'vendor_id');
    }

    public function expenseHead()
    {
        return $this->belongsTo(ExpenseHead::class, 'expense_head_id');
    }

    public function costCenter()
    {
        return $this->belongsTo(CostCenter::class, 'cost_center_id');
    }

    public function student()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function studentInvoice()
    {
        return $this->belongsTo(StudentInvoice::class, 'student_invoice_id');
    }

    public function studentInvoices()
    {
        return $this->hasMany(StudentInvoice::class, 'sales_order_id');
    }

    public function purchaseInvoice()
    {
        return $this->belongsTo(PurchaseInvoice::class, 'purchase_invoice_id');
    }

    public function purchaseInvoices()
    {
        return $this->hasMany(PurchaseInvoice::class, 'purchase_id');
    }
}
