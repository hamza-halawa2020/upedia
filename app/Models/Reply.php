<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reply extends Model
{
    protected $fillable = [
        'request_id',
        'staff_id',
        'reply_text',
        'attachment',
    ];
    public function request()
    {
        return $this->belongsTo(HrRequest::class, 'request_id');
    }
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable', 'model_type', 'model_id');
    }
}