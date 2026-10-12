<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ComplaintStatusHistory extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'complaint_id',
        'old_status',
        'new_status',
        'changed_by',
        'note',
        'created_at',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function complaint()
    {
        return $this->belongsTo(StudentRequest::class, 'complaint_id');
    }

    public function changedBy()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
