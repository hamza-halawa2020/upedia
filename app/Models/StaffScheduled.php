<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StaffScheduled extends CrmModel
{
    protected $table = 'staff_scheduleds';

    public function coursestudents(){
        return $this->hasMany(CourseStudent::class,'course_id');
    }

    public function product(){
        return $this->belongsTo(AcademyProduct::class);
    }

    public function scopeWithPossibleInvoices($query)
    {
        return $query->with(['possibleInvoices']);
    }

    public function possibleInvoices()
    {
        return $this->hasMany(FinanaceStudentInvoice::class, 'product_id', 'track_id');
    }

    public function slots()
    {
        return $this->hasMany(ScheduledSlot::class,'staff_scheduled_id');
    }
    public function scheduledSessions()
    {
        return $this->hasMany(ScheduledSession::class,'staff_scheduled_id');
    }
}
