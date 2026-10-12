<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Assets extends Model
{
    protected $guarded = [];

    public function getTotalCostAttribute(): float
    {
        $accessoriesCost = $this->accessories_sum_cost;

        if ($accessoriesCost === null && $this->relationLoaded('accessories')) {
            $accessoriesCost = $this->accessories
                ->where('enabled', true)
                ->sum('cost');
        }

        return (float) ($this->purchase_cost ?? 0) + (float) ($accessoriesCost ?? 0);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
    public function department()
    {
        return $this->belongsTo(SmHumanDepartment::class, 'department_id');
    }
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
    public function vendor()
    {
        return $this->belongsTo(Vendor::class, 'vendor_id');
    }
    public function accessories()
    {
        return $this->hasMany(AssetAccessory::class ,'asset_id');
    }
}
