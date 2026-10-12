<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LeaveBalanceConfiguration extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'leave_balance_configurations';

    protected $fillable = [
        'leave_type_id',
        'job_title_id',
        'min_hiring_duration_years',
        'full_time_balance',
        'part_time_balance',
        'created_by',
    ];




    /**
     * Relationship to LeaveType
     */
    public function leaveType()
    {
        return $this->belongsTo(LeaveType::class, 'leave_type_id');
    }

    /**
     * Relationship to JobTitle
     */
    public function jobTitle()
    {
        return $this->belongsTo(JobTitle::class, 'job_title_id');
    }

    /**
     * Relationship to User (creator)
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Check if full-time balance is unlimited
     */
    public function isFullTimeUnlimited(): bool
    {
        return is_null($this->full_time_balance);
    }

    /**
     * Check if part-time balance is unlimited
     */
    public function isPartTimeUnlimited(): bool
    {
        return is_null($this->part_time_balance);
    }

    /**
     * Get balance for specific employment type
     */
    public function getBalanceForEmploymentType(string $employmentType): ?int
    {
        $employmentType = strtolower($employmentType);

        if (str_contains($employmentType, 'part')) {
            return $this->part_time_balance;
        }

        return $this->full_time_balance;
    }

    /**
     * Check if balance is unlimited for employment type
     */
    public function isUnlimitedForEmploymentType(string $employmentType): bool
    {
        $employmentType = strtolower($employmentType);

        if (str_contains($employmentType, 'part')) {
            return $this->isPartTimeUnlimited();
        }

        return $this->isFullTimeUnlimited();
    }

    /**
     * Scope to get active configurations only
     */
    public function scopeActive($query)
    {
        return $query->whereNull('deleted_at');
    }

    /**
     * Scope to filter by job title
     */
    public function scopeForJobTitle($query, $jobTitleId)
    {
        return $query->where('job_title_id', $jobTitleId);
    }

    /**
     * Scope to filter by leave type
     */
    public function scopeForLeaveType($query, $leaveTypeId)
    {
        return $query->where('leave_type_id', $leaveTypeId);
    }
}
