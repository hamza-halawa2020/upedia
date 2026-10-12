<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SliderDescription extends Model
{
    protected $table = 'slider_descriptions';

    protected $fillable = [
        'description',
    ];
}
