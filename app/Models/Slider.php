<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Slider extends Model
{
    protected $table = 'student_app_sliders';

    protected $fillable = [
        'title',
        'sub_title',
        'image',
    ];

    protected static function booted()
    {
        static::saved(function () {
            Cache::forget('sliders');
        });

        static::deleted(function () {
            Cache::forget('sliders');
        });
    }
}
