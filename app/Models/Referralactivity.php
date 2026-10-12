<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Referralactivity extends Model
{

    protected $table = 'referralactivities';

    protected $guarded = [];

    // public function user()
    // {
    //     return $this->belongsTo(User::class,'user_id')->withDefault();
    // }
    public function referred()
    {
        return $this->belongsTo(User::class, 'referred_id')->withDefault();
    }
    public function track()
    {
        return $this->belongsTo(Track::class, 'product_id')->withDefault();
    }

    public function track_level()
    {
        return $this->belongsTo(TrackLevel::class, 'product_id')->withDefault();
    }
    public function product()
    {
        return $this->belongsTo(AcademyProduct::class, 'product_id')->withDefault();
    }

    public function referraled()
    {
        return $this->belongsTo(User::class, 'referred_id', 'id');
    }

    public function lead()
    {
        return $this->hasOne(Lead::class, 'referral_activity_id', 'id');
    }

    public function userable()
    {
        return $this->morphTo();
    }

    public function referredable()
    {
        return $this->morphTo();
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
