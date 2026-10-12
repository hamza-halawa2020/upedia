<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CallStatus extends CrmModel
{
    use HasFactory;


    protected $fillable = [
        'name',
        'workflow_id'
    ];

    public function workFlow()
    {
        return $this->belongsTo(WorkFlow::class,'workflow_id');
    }

    public function call()
    {
        return $this->hasMany(Call::class, 'call_status_id');
    }

}
