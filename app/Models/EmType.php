<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmType extends Model
{
    use HasFactory;
    protected $table = 'em_types';
    protected $fillable = [
        'title',
    ];
}
