<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyProductStaff extends Model
{
    use HasFactory;
    protected $table = 'academy_product_staff';
    protected $fillable = [
        'product_id',
        'staff_id'
    ];
    public function product()
    {
        return $this->belongsTo(AcademyProduct::class,'product_id');
    }
    public function staff()
    {
        return $this->belongsTo(Staff::class,'staff_id');
    }
    
}
