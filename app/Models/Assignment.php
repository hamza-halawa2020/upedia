<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    protected $table = 'assignments';
    protected $fillable = [
        'title',
        'description',
        'start_date',
        'end_date',
        'start_time',
        'is_active',
        'end_time',
        'submission_type',
        'max_number_of_uploaded_files',
        'maximum_submission_size',
        'accepted_file_types',
        'staff_scheduled_id',
        'created_by',
    ];

    public function attachments()
    {
        return $this->hasMany(AssignmentAttachment::class, 'assignment_id');
    }

    public function answers()
    {
        return $this->hasMany(AssignmentAnswer::class, 'assignment_id');
    }

    public function staffScheduled()
    {
        return $this->belongsTo(StaffScheduled::class, 'staff_scheduled_id');
    }
    
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
