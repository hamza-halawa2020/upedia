<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AcademyProduct extends Model
{
    use HasFactory;
    protected $table = 'academy_products';
    protected $fillable = [
        'category_product_id',
        'name_en',
        'name_ar',
        'price'
    ];

    public function productType()
    {
        return $this->belongsTo(AcademyCategoryProduct::class,'category_product_id');
    }

    public function productStaff()
    {
        return $this->hasMany(AcademyProductStaff::class);
    }


    public function staff()
    {
        return $this->belongsToMany(Staff::class, 'academy_product_staff', 'product_id', 'staff_id');
    }

    public function invoices()
    {
        return $this->hasMany(FinanaceStudentInvoice::class, 'product_id')
                    ->where('type', 'product');
    }
}
