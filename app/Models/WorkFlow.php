<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkFlow extends Model
{
    use HasFactory;

    protected $table = 'crm_work_flows';

    protected $fillabel = [
        'name',
        'type',
        'action_type',
        'sort',
        'children',
    ];

    public function callStatus()
    {
        return $this->hasMany(CallStatus::class, 'workflow_id');
    }

    public function calls()
    {
        return $this->hasManyThrough(
            \App\Models\Call::class,
            \App\Models\CallStatus::class,
            'workflow_id',
            'call_status_id',
            'id',
            'id'
        );
    }

    protected $casts = [
        'children' => 'array',
    ];
}
