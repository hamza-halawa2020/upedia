<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CertificatePaymentConfiguration extends Model
{
    public $timestamps = false;

    protected $table = 'certificate_payment_configurations';

    protected $fillable = [
        'certificate_type',
        'delivery_type',
        'price',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    public static function activePriceFor(string $certificateType, string $deliveryType): ?self
    {
        return static::query()
            ->where('certificate_type', $certificateType)
            ->where('delivery_type', $deliveryType)
            ->first();
    }
}
