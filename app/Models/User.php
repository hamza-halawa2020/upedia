<?php

namespace App\Models;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class User extends Authenticatable
{
    use HasApiTokens, Notifiable, HasRoles, HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'user_type',
        'applicant_id',
    ];

    public function staff()
    {
        return $this->hasOne(Staff::class, 'user_id');
    }

    public function roles()
    {
        return $this->belongsToMany(Role::class, 'model_has_roles', 'model_id', 'role_id');
    }

    public function authEvents()
    {
        return $this->hasMany(AuthEvent::class);
    }

    public function isCandidate(): bool
    {
        return $this->user_type === 'candidate';
    }

    public function isEmployee(): bool
    {
        return $this->user_type === 'employee' || $this->user_type === null;
    }
    public function deviceTokens()
    {
        return $this->hasMany(UserDeviceToken::class);
    }
}
