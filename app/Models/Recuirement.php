<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Recuirement extends Model
{
    protected $table = 'hr_recuirements';
    protected $fillable = [
        'department_id',
        'job_title_id',
        'priority',
        'salary_range',
        'work_experience',
        'job_type',
        'created_by',
        'report_to',
        'due_date',
        'prefered_age',
        'job_description',
        'required_skills',
    ];
    public function department()
    {
        return $this->belongsTo(SmHumanDepartment::class, 'department_id');
    }
    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function manager()
    {
        return $this->belongsTo(User::class, 'report_to');
    }
    protected static function booted()
    {
        static::creating(function ($recuirements) {
            if (Auth::check()) {
                $recuirements->created_by = Staff::where('user_id', Auth::id())->first()->id;
            }
        });
    }
}
