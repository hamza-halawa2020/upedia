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

    public function department()
    {
        return $this->belongsTo(SmHumanDepartment::class, 'department_id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }

    public function accessories()
    {
        return $this->hasMany(AssetAccessory::class, 'asset_id');
    }

    public function getTotalCostAttribute(): float
    {
        $cost = $this->accessories_sum_cost;
        if ($cost === null && $this->relationLoaded('accessories')) {
            $cost = $this->accessories->where('enabled', true)->sum('cost');
        }

        return (float) $this->purchase_cost + (float) ($cost ?? 0);
    }
}
