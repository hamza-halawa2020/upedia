<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ReferralSetting extends Model
{
    protected $table = 'referral_settings';

    protected $fillable = [
        'referrer_discount',
        'referred_discount',
        'discount_type',
        'discount',
        'created_by',
    ];

    public function track_level()
    {
        return $this->belongsTo(TrackLevel::class, 'product_id')->withDefault();
    }

    public function track()
    {
        return $this->belongsTo(Track::class, 'product_id')->withDefault();
    }

    public function product()
    {
        return $this->belongsTo(AcademyProduct::class, 'product_id')->withDefault();
    }

    public function product_category()
    {
        return $this->belongsTo(Category::class, 'product_category_id')->withDefault();
    }

    public function invoices()
    {
        return $this->hasMany(FinanaceStudentInvoice::class, 'referral_setting_id');
    }

    public function logs()
    {
        return $this->morphMany(Log::class, 'related');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
