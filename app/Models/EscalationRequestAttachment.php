<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EscalationRequestAttachment extends Model
{
    use HasFactory;

    protected $fillable = [
        'escalation_request_id',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'uploaded_by',
    ];

    public function escalationRequest()
    {
        return $this->belongsTo(EscalationRequest::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(Staff::class, 'uploaded_by');
    }
}
