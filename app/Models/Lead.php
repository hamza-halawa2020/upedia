<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Lead extends CrmModel
{
    protected $appends = ['name'];
    protected $guarded = [];
    public function scopeFilter(Builder $builder, $filter)
    {
        $keyword = array_merge([
            'name' => null,
            'email' => null,
            'phone' => null,
            'flag' => null,
            'assigned_to' => null,
            'lead_code' => null,
            'program_id' => null,
            'source' => null,
            'plan_type_id' => null,
            'track_type_id' => null,
            'workflow_id' => null,
            'flag' => null,
            'assign_type' => null,
            'retention' => null,
        ], $filter);
        $builder->when($keyword['name'] ?? null, function (Builder $builder, $value) {
            $phone = str_replace(' ', '', $value);

            $builder->where(function (Builder $query) use ($value, $phone) {
                $query->where('first_name', 'LIKE', "%$value%")
                    ->orWhere('last_name', 'LIKE', "%$value%")
                    ->orWhere('phone', 'LIKE', "%$phone%");
            });
        });
        $builder->when($keyword['assigned_to'], function (Builder $builder, $value) {
            $builder->where('assigned_to', $value);
        });
        $builder->when($keyword['email'], function (Builder $builder, $value) {
            $builder->where('email', $value);
        });
        $builder->when($keyword['phone'], function (Builder $builder, $value) {
            $builder->where('phone', 'like', '%' . str_replace(' ', '', $value) . '%');
        });
        $builder->when($keyword['lead_code'] ?? null, function (Builder $builder, $value) {
            $builder->where('lead_code', 'like', "%$value%");
        });
        $builder->when($keyword['program_id'], function (Builder $builder, $value) {
            $builder->where('program_id', $value);
        });
        $builder->when($keyword['source'], function (Builder $builder, $value) {
            $builder->where('source', $value);
        });
        $builder->when($keyword['plan_type_id'], function (Builder $builder, $value) {
            $builder->where('plan_type_id', $value);
        });
        $builder->when($keyword['track_type_id'], function (Builder $builder, $value) {
            $builder->where('track_type_id', $value);
        });
        $builder->when($keyword['workflow_id'], function (Builder $builder, $value) {
            $builder->where('workflow_id', $value);
        });
        $builder->when($keyword['flag'], function (Builder $builder, $value) {
            $builder->where('flag', $value);
        });
        $builder->when(isset($keyword['assign_type']), function (Builder $builder) use ($keyword) {
            if ($keyword['assign_type'] === 'assigned') {
                $builder->whereNotNull('assigned_to');
            } elseif ($keyword['assign_type'] === 'not_assigned') {
                $builder->whereNull('assigned_to');
            }
        });
        $builder->when($keyword['retention'], function (Builder $builder) {
            $builder->whereHas('creator.staff.department', function ($query) {
                $query->where('slug', 'retention');
            });
        });
    }
    // end local scope

    public function messages()
    {
        return $this->hasMany(Message::class);
    }

    public function assignedUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedStaff(): BelongsTo
    {
        return $this->belongsTo(Staff::class, 'assigned_staff_id');
    }

    public function assignments(): HasMany
    {
        return $this->hasMany(LeadAssignment::class);
    }

    public function latestAssignment(): HasOne
    {
        return $this->hasOne(LeadAssignment::class)->latestOfMany();
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'creator_id');
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'related');
    }

    public function tasks()
    {
        return $this->morphMany(Task::class, 'related_to');
    }

    public function calls()
    {
        return $this->morphMany(Call::class, 'related_to');
    }

    public function scopeWithAssignedUsers($query)
    {
        return $query->with('assignedUser');
    }

    public function scopeWithLatestAssignment($query)
    {
        return $query->with('latestAssignment');
    }

    public function scopeWhereAvailable($query)
    {
        return $query->where('is_converted', false);
    }
    public function scopeWhereConverted($query)
    {
        return $query->where('is_converted', true);
    }

    public function lead_status(): BelongsTo
    {
        return $this->belongsTo(LeadsStatus::class, 'status_id');
    }

    public function status(): BelongsTo
    {
        return $this->lead_status();
    }

    public function scopeWithStatus($query)
    {
        return $query->with('lead_status');
    }

    public function workflow()
    {
        return $this->belongsTo(WorkFlow::class, 'workflow_id', 'id');
    }
    public function getNameAttribute(): string
    {
        return "$this->first_name $this->last_name";
    }
    public function parent()
    {
        return $this->belongsTo(StudentParent::class, 'parent_id');
    }
    public function students()
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    public function referralactivity()
    {
        return $this->belongsTo(Referralactivity::class, 'referral_activity_id', 'id');
    }
    public function pricingplantype()
    {
        return $this->belongsTo(PricingPlanType::class, 'plan_type_id', 'id');
    }

    public function referralActivityUsers()
    {
        return $this->morphMany(ReferralActivity::class, 'userable');
    }

    public function referralActivityReferrals()
    {
        return $this->morphMany(ReferralActivity::class, 'referredable');
    }
    protected $casts = [
        'workflow_log' => 'array',
        'comments' => 'array',
        'facebook_psid' => 'array',
        'last_reminder_time' => 'datetime',
        'preferred_contact_at' => 'datetime',
    ];
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($lead) {
            if ($lead->date_of_birth) {
                $lead->age = Carbon::parse($lead->date_of_birth)->age;
            }
        });
    }

    private function maskPhone($phone)
    {
        if (!$phone) {
            return null;
        }

        $user = Auth::user();

        if ($user && $user->can('retention_view_full_student_mobile')) {
            return $phone;
        }

        return '**** **** ' . substr($phone, -4);
    }

    public function getPhoneMaskedAttribute()
    {
        return $this->maskPhone($this->phone);
    }
}
