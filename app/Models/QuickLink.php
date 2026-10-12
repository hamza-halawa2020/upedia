<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuickLink extends Model
{
    protected $fillable = [
        'name',
        'link',
        'is_active',
        'created_by'
    ];

    public function departments()
    {
        return $this->belongsToMany(SmHumanDepartment::class, 'quick_link_departments', 'quick_link_id', 'department_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
