<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Script extends Model
{
    protected $guarded = [];

    public function departments(): BelongsToMany
    {
        return $this->belongsToMany(SmHumanDepartment::class,'script_sm_human_department')->withTimestamps();
    }
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable', 'model_type', 'model_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function approver()
    {
        return $this->belongsTo(User::class, 'approved_by');
    }
}