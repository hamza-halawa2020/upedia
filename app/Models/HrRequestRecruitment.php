<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrRequestRecruitment extends Model
{
    protected $table = 'hr_request_recruitments';

    protected $fillable = [
        'request_id',
        'job_title_id',
        'role_description',
        'required_qualifications_skills',
        'number_of_vacancies',
        'expected_start_date',
        'justification_reason',
        'category_id',
        'track_type_ids',
        'track_ids',
        'shift_time_ids',
        'shift_time', //morning, night
    ];

    protected $casts = [
        'track_type_ids' => 'array',
        'track_ids' => 'array',
        'shift_time_ids' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }

    public function requests()
    {
        return $this->belongsTo(HrRequest::class, 'request_id');

    }

    public function jobTitles()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');

    }
    public function applicants()
    {
        return $this->hasMany(Applicant::class, 'recruitment_id');

    }
    public static function reportConfig()
    {
        return [
            'label' => 'Recruitment Report',
            'relations' => ['requests.department', 'jobTitles'],
            'fields' => [
                'requests.department.name' => 'Department',
                'jobTitles.name' => 'Job Title',
                'requests.priority' => 'Priority',
                'requests.status' => 'Request Status',
            ],
            'filters' => [
                'requests.department_id' => ['type' => 'select', 'model' => SmHumanDepartment::class, 'label' => 'Department'],
                'job_title_id' => ['type' => 'select', 'model' => JobTitle::class, 'label' => 'Job Title'],
            ]
        ];
    }
}
