<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TrackType extends Model
{
    use HasFactory;

    protected $table = 'track_types';

    protected $fillable = [
        'name',
        'count_of_students'
    ];

    
}