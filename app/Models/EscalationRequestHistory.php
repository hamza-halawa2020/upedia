<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscalationRequestHistory extends Model
{
    use HasFactory;

    protected $fillable = [
        'escalation_request_id',
        'action',
        'from_status',
        'to_status',
        'note',
        'created_by',
    ];

    public function escalationRequest()
    {
        return $this->belongsTo(EscalationRequest::class);
    }

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }
}
