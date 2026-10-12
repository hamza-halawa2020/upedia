<?php

namespace App\Models;

use App\Models\Staff;
use App\Models\Attachment;
use Illuminate\Support\Facades\Auth;
use Illuminate\Database\Eloquent\Model;

class Complain extends Model
{
    protected $guarded = [];
    public function staff()
    {
        return $this->belongsTo(Staff::class, 'created_by');
    }
    public function sales()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
    public function solver()
    {
        return $this->belongsTo(User::class, 'solved_by');
    }
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable', 'model_type', 'model_id');
    }
    protected static function boot()
    {
        parent::boot();
        static::creating(function ($plan) {
            if (Auth::check()) {
                $staff_id = Staff::where('user_id', Auth::id())->first()->id;
                $plan->created_by = $staff_id;
            }
        });
    }
}