<?php

namespace App\Models;

use App\Scopes\ActiveStatusSchoolScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


class SmBaseSetup extends Model
{
	protected static function boot()
    {
        parent::boot();
  
        // static::addGlobalScope(new ActiveStatusSchoolScope);
    } 
	use HasFactory;

}
