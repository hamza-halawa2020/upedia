<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobTitle extends Model
{

    protected $table = 'hr_job_titles';

    protected $fillable = [
        'name',
        'mail_alias',
        'department_id',
        'status',
        'slug',
        'sort'
    ];

    public function department()
    {
        return $this->belongsTo(SmHumanDepartment::class);
    }
    public function staffs()
    {
        return $this->hasMany(Staff::class, 'job_title_id');
    }
}
