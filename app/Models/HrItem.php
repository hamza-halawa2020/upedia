<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrItem extends Model
{
    protected $table = 'hr_items';

    protected $fillable = [
        'name',
        'created_by',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
