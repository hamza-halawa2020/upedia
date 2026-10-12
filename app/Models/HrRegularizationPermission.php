<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;

class HrRegularizationPermission extends Model
{
    protected $table = 'hr_regularizations_permissions';
    protected $fillable = [
        'staff_id',
        'date',
        'from_time',
        'end_time',
        'reason',
        'type',
        'permission',
        "approval_status",
        "approved_at" ,
        'approved_by',
        'approved_hr_by'
    ];
    public $appends = ['approved_by_name','approved_hr_by_name'];
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }

    public function approvedBy()
    {
        return $this->belongsTo(Staff::class, 'approved_by');
    }

    public function approvedHrBy()
    {
        return $this->belongsTo(Staff::class, 'approved_hr_by');
    }

    protected function fromTime(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? \Carbon\Carbon::parse($value)->format('H:i') : null,
        );
    }

    // Accessor for end_time
    protected function endTime(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $value ? \Carbon\Carbon::parse($value)->format('H:i') : null,
        );
    }


    public  function HrRegularizationsDates()
    {
        return $this->hasMany(HrRegularizationPeriod::class,'hr_regularization_permission_id' , 'id');
    }


    public function approvedByName()  : Attribute
    {
        return Attribute::make(
         get: fn() => $this->approved_by ? $this->approvalStaffName($this->approvedBy) : null
        );
    }
    public function approvedHrByName()  : Attribute
    {
        return Attribute::make(
         get: fn() => $this->approved_hr_by ? $this->approvalStaffName($this->approvedHrBy) : null
        );
    }

    private function approvalStaffName(?Staff $staff): ?string
    {
        if (! $staff) {
            return null;
        }

        return $staff->getRawOriginal('full_name')
            ?: trim((string) $staff->first_name . ' ' . (string) $staff->getRawOriginal('last_name'));
    }

}
