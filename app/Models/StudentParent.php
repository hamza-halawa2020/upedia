<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentParent extends Model
{
    use HasFactory;
    protected $table = 'sm_parents';
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function student()
    {
        return $this->hasMany(Student::class, 'parent_id');
    }
}
