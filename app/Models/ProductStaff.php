<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductStaff extends Model
{
    use HasFactory;

    protected $table = 'academy_product_staff';

    protected $fillable = [
        'product_id',
        'staff_id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class,'product_id');
    }
}
