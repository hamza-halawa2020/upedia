<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Viewable;

class Announcement extends Model
{
    use HasFactory, Viewable;

    protected $table = 'announcements';

    protected $fillable = [
        'title',
        'message',
        'category',
        'location',
        'expiry_date',
        'status',
        'visibility',
        'notify_all',
        'students_only',
        'created_by',
    ];

    protected $casts = [
        'students_only' => 'boolean',
        'notify_all' => 'boolean',
        'expiry_date' => 'date',
    ];

    public function departments()
    {
        return $this->belongsToMany(SmHumanDepartment::class, 'announcement_departments', 'announcement_id', 'department_id');
    }

    public function individualRecipients()
    {
        return $this->belongsToMany(Staff::class, 'announcement_staffs', 'announcement_id', 'staff_id');
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'model');
    }

    public function creator()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }
}