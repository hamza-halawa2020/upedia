<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuthEvent extends Model
{
    protected $table = 'auth_events';
    protected  $guarded =  [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public static function boot()
    {
        parent::boot();
        static::created(function ($event) {
            if ($event->event_type === 'login') {
                $lastLogout = AuthEvent::where('user_id', $event->user_id)
                    ->where('event_type', 'logout')
                    ->where('created_at', '<', $event->created_at)
                    ->latest()
                    ->first();
                if ($lastLogout) {
                    $seconds =  $lastLogout->created_at->diffInSeconds($event->created_at);
                    $event->idle_seconds = $seconds;
                    $event->save();
                }
            }
        });
    }

}
