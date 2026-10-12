<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendor extends Model
{
    protected $guarded = [];
    protected $table = 'it_vendors';
    public function purchases()
    {
        return $this->hasMany(Purchase::class, 'vendor_id');
    }

    public function purchaseInvoices()
    {
        return $this->hasMany(PurchaseInvoice::class, 'vendor_id');
    }
}
