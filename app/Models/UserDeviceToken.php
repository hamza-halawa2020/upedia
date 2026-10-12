<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDeviceToken extends Model
{
    protected $fillable = [
        'user_id',
        'device_token',
        'token_hash',
        'device_type',
        'device_name',
        'project',
        'is_active',
        'last_used_at',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'last_used_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
