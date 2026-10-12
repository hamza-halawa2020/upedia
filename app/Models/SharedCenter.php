<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class SharedCenter extends Model
{
    protected $table = 'hr_shared_centers';

    
    protected $fillable = [
        'name',
        'folder_id',
        'status',
        'valid_until',
        'description',
        'share_department_id',
        'share_staff_id',
        'attachment_type',
        'attachment',
        'notifications'
    ];

    protected $guarded = [];
    public function shared_center_folder()
    {
        return $this->belongsTo(SharedCenterFolder::class , 'folder_id');
    }
    public function department()
    {
        return $this->belongsTo(SmHumanDepartment::class , 'share_department_id');
    }
    public function staff()
    {
        return $this->belongsTo(Staff::class , 'share_staff_id');
    }

    public function scopeVisibleToStaff(Builder $query, ?Staff $staff): Builder
    {
        if (!$staff) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where(function (Builder $visibilityQuery) use ($staff) {
            $visibilityQuery->where('share_staff_id', $staff->id)
                ->orWhere(function (Builder $departmentQuery) use ($staff) {
                    $departmentQuery->where('share_department_id', $staff->department_id)
                        ->whereNull('share_staff_id');
                });
        });
    }
}
