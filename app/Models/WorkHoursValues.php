<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WorkHoursValues extends Model
{
    /** @use HasFactory<\Database\Factories\WorkHoursVakuesFactory> */
    use HasFactory;


    protected $fillable = [
               'full_time_hours',
               'part_time_hours',

    ];
}
