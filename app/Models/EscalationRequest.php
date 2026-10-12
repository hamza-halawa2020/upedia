<?php

namespace App\Models;

use App\Enums\EscalationRequestStatus;
use App\Traits\Noteable;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EscalationRequest extends Model
{
    use HasFactory;
    use Noteable;
    use SoftDeletes;

    protected $fillable = [
        'from_department_id',
        'to_department_id',
        'student_request_id',
        'hr_request_id',
        'title',
        'description',
        'assigned_to',
        'status',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'status' => EscalationRequestStatus::class,
    ];

    public function fromDepartment()
    {
        return $this->belongsTo(SmHumanDepartment::class, 'from_department_id');
    }

    public function toDepartment()
    {
        return $this->belongsTo(SmHumanDepartment::class, 'to_department_id');
    }

    public function studentRequest()
    {
        return $this->belongsTo(StudentRequest::class, 'student_request_id');
    }

    public function hrRequest()
    {
        return $this->belongsTo(HrRequest::class, 'hr_request_id');
    }

    public function assignedTo()
    {
        return $this->belongsTo(Staff::class, 'assigned_to');
    }

    public function creator()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }

    public function updater()
    {
        return $this->belongsTo(Staff::class, 'updated_by');
    }

    public function attachments()
    {
        return $this->hasMany(EscalationRequestAttachment::class);
    }

    public function histories()
    {
        return $this->hasMany(EscalationRequestHistory::class)->latest();
    }

    public function scopeVisibleForUser(Builder $query, User $user): Builder
    {
        if ($user->hasRole('CEO')) {
            return $query;
        }

        $staff = $user->staff;

        if (! $staff) {
            return $query->whereRaw('1 = 0');
        }

        return $query->where(function (Builder $visibleQuery) use ($staff) {
            $visibleQuery
                ->where('created_by', $staff->id)
                ->orWhere(function (Builder $managerQuery) use ($staff) {
                    $managerQuery
                        ->where('to_department_id', $staff->department_id)
                        ->whereHas('toDepartment', function (Builder $departmentQuery) use ($staff) {
                            $departmentQuery->where('department_head_id', $staff->id);
                        });
                })
                ->orWhere(function (Builder $managerFallbackQuery) use ($staff) {
                    $managerFallbackQuery
                        ->where('to_department_id', $staff->department_id)
                        ->whereHas('toDepartment')
                        ->whereHas('toDepartment.staffs', function (Builder $staffQuery) use ($staff) {
                            $staffQuery
                                ->where('sm_staffs.id', $staff->id)
                                ->whereHas('jobTitle', fn (Builder $jobTitleQuery) => $jobTitleQuery->where('sort', 1));
                        });
                });
        });
    }

    public function scopeUnassigned(Builder $query): Builder
    {
        return $query->whereNull('assigned_to');
    }

    public function scopeAssignedTo(Builder $query, int $staffId): Builder
    {
        return $query->where('assigned_to', $staffId);
    }

    public function scopeForReceiverDepartment(Builder $query, int $departmentId): Builder
    {
        return $query->where('to_department_id', $departmentId);
    }

    public function scopeFilter(Builder $query, array $filters): Builder
    {
        return $query
            ->when($filters['from_department_id'] ?? null, fn (Builder $q, $value) => $q->where('from_department_id', $value))
            ->when($filters['to_department_id'] ?? null, fn (Builder $q, $value) => $q->where('to_department_id', $value))
            ->when($filters['student_request_id'] ?? null, fn (Builder $q, $value) => $q->where('student_request_id', $value))
            ->when($filters['hr_request_id'] ?? null, fn (Builder $q, $value) => $q->where('hr_request_id', $value))
            ->when($filters['status'] ?? null, fn (Builder $q, $value) => $q->where('status', $value))
            ->when($filters['assigned_to'] ?? null, fn (Builder $q, $value) => $q->where('assigned_to', $value))
            ->when($filters['created_by'] ?? null, fn (Builder $q, $value) => $q->where('created_by', $value))
            ->when(! empty($filters['unassigned_only']), fn (Builder $q) => $q->whereNull('assigned_to'))
            ->when(! empty($filters['assigned_to_me']) && ! empty($filters['current_staff_id']), fn (Builder $q) => $q->where('assigned_to', $filters['current_staff_id']))
            ->when($filters['date_from'] ?? null, fn (Builder $q, $value) => $q->whereDate('created_at', '>=', $value))
            ->when($filters['date_to'] ?? null, fn (Builder $q, $value) => $q->whereDate('created_at', '<=', $value))
            ->when($filters['search'] ?? null, function (Builder $q, $search) {
                $q->where(function (Builder $searchQuery) use ($search) {
                    $searchQuery
                        ->where('title', 'like', "%{$search}%")
                        ->orWhere('description', 'like', "%{$search}%")
                        ->orWhereHas('studentRequest', function (Builder $studentRequestQuery) use ($search) {
                            $studentRequestQuery
                                ->where('subject', 'like', "%{$search}%")
                                ->orWhere('description', 'like', "%{$search}%");
                        })
                        ->orWhereHas('hrRequest', function (Builder $hrRequestQuery) use ($search) {
                            $hrRequestQuery
                                ->where('details', 'like', "%{$search}%")
                                ->orWhere('notes', 'like', "%{$search}%")
                                ->orWhere('id', $search)
                                ->orWhereHas('requestType', function (Builder $requestTypeQuery) use ($search) {
                                    $requestTypeQuery->where('name', 'like', "%{$search}%");
                                });
                        });
                });
            });
    }
}
