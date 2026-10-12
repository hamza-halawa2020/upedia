<?php

namespace App\Models;

use App\Models\SharedCenter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class SharedCenterFolder extends Model
{
    protected $table = 'hr_shared_center_folders';
    protected $guarded = [];

    protected $with = ['user:id,full_name'];
    public function shared_center()
    {
        return $this->hasMany(SharedCenter::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            if (Auth::check()) {
                $model->created_by = Auth::id();
            }
        });
    }
}
