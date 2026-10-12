<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $guarded = ["id"];

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
    ];

    /**
     * Scope a query to only include unread notifications.
     */
    public function isUnread()
    {
        return is_null($this->read_at);
    }

    /**
     * Get the notifiable model that the notification belongs to.
     */
    public function notifiable()
    {
        return $this->morphTo();
    }

    public function markAsRead()
    {
        $this->read_at = now();
        $this->save();
    }
}
