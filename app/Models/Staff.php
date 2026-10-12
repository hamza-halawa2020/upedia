<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use \Illuminate\Database\Eloquent\Builder;

class Staff extends Model
{
    use HasFactory;
    protected $table = 'sm_staffs';
    protected static function booted()
    {
        static::addGlobalScope('active', function (Builder $builder) {
            $builder->where('active_status', '!=', 0);
        });
    }


    protected $fillable = [
        'staff_no',
        'role_id',
        'role_type',
        'department_id',
        'designation_id',
        'first_name',
        'last_name',
        'fathers_name',
        'mothers_name',
        'email',
        'staff_photo',
        'gender_id',
        'marital_status',
        'date_of_birth',
        'date_of_joining',

        'current_address',
        'permanent_address',
        'qualification',
        'experience',
        'epf_no',
        'basic_salary',
        'contract_type',
        'location',
        'bank_account_name',
        'bank_account_no',
        'bank_name',
        'bank_brach',
        'facebook_url',
        'twiteer_url',
        'linkedin_url',
        'instragram_url',
        'resume',
        'joining_letter',
        'other_document',
        'driving_license',
        'hourly_rate',
        'customF.*',
        'id_number',
        'other_id',
        'religion',
        'home_phone',
        'other_email',
        'city',
        'job_title_id',
        'reporting_to',
        'secondary_reporting_to',
        'country_id',
        'source_of_hire',
        'contract',
        'contract_renewal_date',
        'age',
        'id_expiry_date',

        'mobile',
        'mobile_country_code',
        'another_mobile',
        'another_mobile_country_code',
        'mobile_dial_code',
        'another_mobile_dial_code',
        'full_name',
        'manager_id',
        'shift_emp_id',
        'user_id',
        'shift_type',
        'check_in',
        'check_out',
        'payment_type', // bank, wallet, cash
        'package', // fixed, non-fixed
        'wallet_number',
        'work_from',
        'work_to',
        'active_status'

    ];

    public function department()
    {
        return $this->belongsTo(SmHumanDepartment::class);
    }


    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }
    // public function role()
    // {
    //     return $this->belongsTo(Role::class);
    // }
    // public function department()
    // {
    //     return $this->belongsTo(SmHumanDepartment::class);
    // }
    // public function designation()
    // {
    //     return $this->belongsTo(SmDesignation::class);
    // }
    // public function user()
    // {
    //     return $this->belongsTo(User::class);
    // }
    // public function workExperiences()
    // {
    //     return $this->hasMany(StaffWorkExperience::class);
    // }
    // public function productStaff()
    // {
    //     return $this->hasMany(ProductStaff::class);
    // }
    // public function educations()
    // {
    //     return $this->hasMany(StaffEducation::class);
    // }
    // public function TrackAssignedStaff()
    // {
    //     return $this->hasMany(TrackAssignedStaff::class);
    // }
    // public function slots()
    // {
    //     return $this->hasMany(StaffSlot::class);
    // }
    // public function products()
    // {
    //     return $this->hasMany(ProductStaff::class);
    // }

    // public function ExpertTeacher()
    // {
    //     return $this->hasOne(SmExpertTeacher::class);
    // }
}
