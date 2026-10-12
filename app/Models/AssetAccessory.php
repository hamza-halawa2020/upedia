<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssetAccessory extends Model
{
    protected $fillable = [
        'asset_id',
        'type',
        'brand',
        'cost',
        'enabled',
    ];
    public function asset()
    {
        return $this->belongsTo(Assets::class);
    }
}
