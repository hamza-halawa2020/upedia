<?php

namespace App\Models;

use App\Models\Staff;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Carbon as SupportCarbon;
use Illuminate\Support\Facades\Auth;

class Call extends CrmModel
{
    protected $table = 'crm_calls';

    protected $casts = [
        'call_time' => 'datetime',
        'schedule_call_time' => 'datetime',
        'last_reminder_sent_at' => 'datetime',
    ];

    public function callStatus()
    {
        return $this->belongsTo(CallStatus::class, 'call_status_id');
    }

    public function relatedTo()
    {
        return $this->morphTo();
    }

    public function reason()
    {
        return $this->belongsTo(Reason::class, 'reason_id', 'id')->withDefault();
    }

    public function scopeFilter(Builder $builder, $query)
    {
        $keyword = array_merge([
            'from' => null,
            'to' => null,
            'auth' => null,
        ], $query);
        if (! $keyword['from'] && ! $keyword['to']) {
            $builder->whereDate('created_at', Carbon::today());
        } else {
            $builder->when($keyword['from'], function (Builder $builder, $value) {
                $builder->whereDate('created_at', '>=', Carbon::parse($value)->startOfDay());
            });
            $builder->when($keyword['to'], function (Builder $builder, $value) {
                $builder->whereDate('created_at', '<=', Carbon::parse($value)->endOfDay());
            });
        }
        $builder->when($keyword['auth'], function (Builder $builder, $value) {
            $builder->where('related_to_id', Auth::id());
        });
    }

    public function reminderAt(): SupportCarbon
    {
        return $this->call_time instanceof SupportCarbon
            ? $this->call_time
            : SupportCarbon::parse($this->call_time);
    }

    public function assignedUser(): ?User
    {
        $related = $this->relatedTo;

        if ($related instanceof Lead && $related->assigned_to) {
            $staffUser = Staff::query()->find($related->assigned_to)?->user;

            if ($staffUser) {
                return $staffUser;
            }

            $assignedUser = User::query()->find($related->assigned_to);

            if ($assignedUser) {
                return $assignedUser;
            }
        }

        $assigned = $related?->assignedUser;

        return $assigned instanceof Staff
            ? $assigned->user
            : ($assigned ?? $related?->creator);
    }
}
