<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Asset extends Model
{
    protected $table = 'assets';

    protected $fillable = [
        'product_id',
        'name',
        'model',
        'serial_number',
        'manufacturer',
        'vendor_id',
        'barcode',
        'purchase_cost',
        'acquisition_date',
        'warranty_expiry_date',
        'site',
        'department_id',
        'is_currently_in_use',
        'user_id',
        'processor',
        'hard_disk',
        'ram',
    ];

    protected $casts = [
        'purchase_cost' => 'decimal:2',
        'acquisition_date' => 'date',
        'warranty_expiry_date' => 'date',
        'ram' => 'integer',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

        public function product()
    {
        return $this->belongsTo(ItProduct::class, 'product_id');
    }

    // public function department()
    // {
    //     return $this->belongsTo(Department::class, 'department_id');
    // }
}
