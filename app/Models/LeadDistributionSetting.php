<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeadDistributionSetting extends Model
{
    public const METHOD_AUTOMATIC = 'automatic';
    public const METHOD_PERCENTAGE = 'percentage';
    public const METHOD_MANUAL = 'manual';

    protected $table = 'lead_distribution_settings';

    protected $guarded = ['id'];

    public function percentageRules(): HasMany
    {
        return $this->hasMany(LeadDistributionPercentageRule::class);
    }

    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updater(): BelongsTo
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
