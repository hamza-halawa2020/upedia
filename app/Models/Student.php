<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Student extends Model
{
    use HasFactory;
    protected $table = 'sm_students';
    protected $fillable = [
        'admission_no',
        'first_name',
        'last_name',
        'full_name',
        'date_of_birth',
        'caste',
        'email',
        'gender_id',
        'mobile',
        'student_photo',
        'current_address',
        'permanent_address',
        'bank_account_no',
        'bank_name',
        'ifsc_code',
        'previous_school_details',
        'user_id',
        'school_id',
        'national_id_no',
        'age',
        'aditional_notes',
        'document_title_1',
        'document_title_2',
        'document_title_3',
        'document_title_4',
        'document_file_1',
        'document_file_2',
        'document_file_3',
        'document_file_4',
        'parent_id',
        'pricing_plan_type_id',
        'religion',
        'another_mobile',
        'country_id',
        'mobile_country_code',
        'another_mobile_country_code',
        'track_type_id',
        'mobile_dial_code',
        'another_mobile_dial_code',
        'student_code',
        'created_by',
        'referral_activity_id',
    ];


    public function invoices()
    {
        return $this->hasMany(FinanaceStudentInvoice::class, 'student_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function trackType()
    {
        return $this->belongsTo(SmBaseSetup::class,'track_type_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class,'created_by');
    }
    public function parent()
    {
        return $this->belongsTo(StudentParent::class, 'parent_id');
    }
    public function gender()
    {
        return $this->belongsTo(SmBaseSetup::class, 'gender_id');
    }

    public function courseStudents()
    {
        return $this->hasMany(CourseStudent::class, 'student_id');
    }

    public function bookingRequests()
    {
        return $this->hasMany(CrmBookingRequest::class, 'student_id');
    }
    public function pricingPlanType()
    {
        return $this->belongsTo(PricingPlanType::class, 'pricing_plan_type_id');
    }
    public function country()
    {
        return $this->belongsTo(Country::class, 'country_id');
    }
    public function mobileCountryCode()
    {
        return $this->belongsTo(Country::class, 'mobile_country_code');
    }
    public function anotherMobileCountryCode()
    {
        return $this->belongsTo(Country::class, 'another_mobile_country_code');
    }
    public function nationality()
    {
        return $this->belongsTo(Nationality::class, 'national_id_no');
    }

    public function urgent()
    {
        return $this->hasMany(Urgent::class, 'student_id');
    }
    public function admins()
    {
        return $this->hasMany(AdminAssignedStudent::class, 'student_id');
    }
    public function leads()
    {
        return $this->hasMany(Lead::class, 'student_id');
    }

    public function referralactivity()
    {
        return $this->belongsTo(Referralactivity::class, 'referral_activity_id', 'id');
    }

    public function referralActivityUsers()
    {
        return $this->morphMany(Referralactivity::class, 'userable');
    }

    public function referralActivityReferrals()
    {
        return $this->morphMany(Referralactivity::class, 'referredable');
    }

     
    private function maskMobile($mobile)
    {
        if (!$mobile) {
            return null;
        }

        $user = Auth::user();

        if ($user && $user->can('retention_view_full_student_mobile')) {
            return $mobile;
        }

        return '**** **** ' . substr($mobile, -4);
    }

    public function getMobileAttribute($value)
    {
        return $this->maskMobile($value);
    }

    public function getAnotherMobileAttribute($value)
    {
        return $this->maskMobile($value);
    }

    public function getMobileMaskedAttribute()
    {
        return $this->maskMobile($this->getRawOriginal('mobile'));
    }

    public function getAnotherMobileMaskedAttribute()
    {
        return $this->maskMobile($this->getRawOriginal('another_mobile'));
    }

    public function teacherFeedbacks()
    {
        return $this->hasMany(TeacherFeedback::class, 'student_id');
    }
}
