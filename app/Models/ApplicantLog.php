<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApplicantLog extends Model
{
    protected $table = 'applicant_logs';

    protected $fillable = [
        'applicant_id',
        'changed_by',
        'field',
        'old_value',
        'new_value',
    ];

    public function applicant()
    {
        return $this->belongsTo(Applicant::class,'applicant_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'changed_by');
    }
}
