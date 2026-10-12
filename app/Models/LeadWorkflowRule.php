<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeadWorkflowRule extends Model
{
    protected $guarded = ['id'];

    protected $casts = [
        'attempt_limit' => 'integer',
        'notify_creator' => 'boolean',
        'unassign_lead' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function workflow(): BelongsTo
    {
        return $this->belongsTo(WorkFlow::class, 'workflow_id');
    }
}
