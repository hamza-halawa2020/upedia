<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LeadsReminderSetting extends Model
{
    protected $table = 'leads_reminder_settings';

    protected $guarded = ["id"];

    protected $casts = [
        'action' => 'array',
    ];
}
