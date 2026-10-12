<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rule extends Model
{
    /** @use HasFactory<\Database\Factories\RuleFactory> */
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'description',
        'type',
        'value',
        'units',
        'status',
        'insert_type',
        'time_check_unit',
        'created_by',
        'updated_by',
        'deleted_by',
        'apply_to',
    ];

    public function scopeActive(Builder $query)
    {
        return $query->where('status', 'active');
    }

    public function scopeType(Builder $query, $type)
    {
        return $query->where('type', $type);
    }

    public function compensation()
    {
        return $this->hasMany(Compensation::class);
    }

    public function employees()
    {
        return $this->belongsToMany(User::class, 'compensations', 'rule_id', 'user_id');
    }

    public function employee()
    {
       return $this->employees()->where('user_id' , auth()->id());
    }

    public function scopeEffectCode($query, $code)
    {
        return $query->where('effect_code', $code);
    }

    public function ruleLevels()
    {
        return $this->hasMany(HrRuleLevel::class, 'hr_rule_id')->orderBy('level_number');
    }

    /**
     * Get the next rule level for a user based on existing compensations
     * Returns the level that should be applied for the next compensation
     *
     * @param int $userId The user ID
     * @return HrRuleLevel|null The next rule level or null if no levels exist
     */
    public function getNextRuleLevel($userId)
    {
        // Only calculate levels for penalty rules
        if ($this->type !== 'penalty') {
            return null;
        }

        // Count how many times this rule was applied to this user
        $compensationsCount = \App\Models\Compensation::where('user_id', $userId)
            ->where('rule_id', $this->id)
            ->count();

        // Calculate next level number
        $nextLevelNumber = $compensationsCount + 1;

        // Get the level for this level number
        $level = $this->ruleLevels()
            ->where('level_number', $nextLevelNumber)
            ->first();

        // If the level doesn't exist, fallback to the highest available level
        if (!$level) {
            $level = $this->ruleLevels()
                ->orderBy('level_number', 'desc')
                ->first();
        }

        return $level;
    }

    /**
     * Get the penalty details for a specific level
     */
    public function getLevelPenalty($levelNumber)
    {
        return $this->ruleLevels()
            ->where('level_number', $levelNumber)
            ->first();
    }

//    public function jobTitles()
//    {
//        return $this->belongsToMany(JobTitle::class, 'hr_job_titles', 'rule_id', 'job_title_id');
//    }

}
