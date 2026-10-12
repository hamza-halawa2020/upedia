<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RefundRequestHistory extends Model
{
    use HasFactory;

    protected $table = 'student_request_histories';

    protected $fillable = [
        'student_request_id',
        'from_status',
        'to_status',
        'status_note',
        'status_changed_by',
        'deduct_admin_expenses',
        'additional_amount',
        'performed_by_user_id',
    ];

    protected $casts = [
        'deduct_admin_expenses' => 'boolean',
        'additional_amount' => 'decimal:2',
    ];

    public function request()
    {
        return $this->belongsTo(RefundRequest::class, 'student_request_id');
    }

    public function performedBy()
    {
        return $this->belongsTo(User::class, 'performed_by_user_id');
    }
}

