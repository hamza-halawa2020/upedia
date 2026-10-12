<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OutBoxEvent extends Model
{
     protected $table = 'outbox_events';
     protected  $guarded = [];
}
