<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HrRuleLevel extends Model
{
    use HasFactory;

    protected $table = 'hr_rule_levels';

    protected $fillable = [
        'hr_rule_id',
        'level_number',
        'penalty_type',
        'penalty_value',
    ];

    protected $casts = [
        'penalty_value' => 'decimal:2',
        'level_number' => 'integer',
    ];

    public function rule()
    {
        return $this->belongsTo(Rule::class, 'hr_rule_id');
    }
}
