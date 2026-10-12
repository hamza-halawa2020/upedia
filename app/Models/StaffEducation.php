<?php

namespace App\Models;

use App\SmStaff;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StaffEducation extends Model
{
    use HasFactory;

    protected $fillable = [
        'staff_id',
        'university',
        'degree',
        'specialization',
        'date_of_completion',
        'notes',
    ];

    public function staff()
    {
        return $this->belongsTo(Staff::class, 'staff_id');
    }
}
