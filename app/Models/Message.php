<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    

    // in Message.php
    public function lead()
    {
        return $this->belongsTo(Lead::class);
    }   
}
