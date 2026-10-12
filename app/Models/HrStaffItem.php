<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrStaffItem extends Model
{
    protected $table = 'hr_staff_items';

    protected $fillable = [
        'staff_id',
        'created_by',
        'item_id',
        'received_date',
        'returned_date',
        'notes',
        'quantity',
        'status', // delivered, returned, lost, pending
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');

    }

    public function item()
    {
        return $this->belongsTo(HrItem::class, 'item_id');

    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');

    }
}
