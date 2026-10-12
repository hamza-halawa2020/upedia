<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * @property int $id
 * @property int $first_notification_before
 * @property int $second_notification_after
 * @property string $working_hour_start
 * @property string $working_hour_end
 * @property \Illuminate\Support\Carbon $created_at
 * @property \Illuminate\Support\Carbon $updated_at
 */
class FirebaseNotificationConfig extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_notification_before',
        'second_notification_after',
        'working_hour_start',
        'working_hour_end',

    ];
}
