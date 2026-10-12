<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadDistributionPercentageRule extends Model
{
    protected $table = 'lead_distribution_percentage_rules';

    protected $guarded = ['id'];

    protected $casts = [
        'percentage' => 'decimal:2',
    ];

    public function setting(): BelongsTo
    {
        return $this->belongsTo(LeadDistributionSetting::class, 'lead_distribution_setting_id');
    }

    public function staff(): BelongsTo
    {
        return $this->belongsTo(Staff::class);
    }
}
