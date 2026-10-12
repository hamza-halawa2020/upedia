<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryJob extends Model
{
    
    protected $table = 'hr_category_jobs';

    protected $fillable = [
        'name',
    ];

    public function jobTitles()
    {
        return $this->hasMany(JobTitle::class);
    }

}
