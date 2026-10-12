<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TrackPricingPlan extends Model
{
    protected $table = 'track_pricing_plans';

    public function package()
    {
        return $this->belongsTo(Package::class, 'package_id');
    }

    public function track()
    {
        return $this->belongsTo(Track::class, 'track_id');
    }

    public function trackType()
    {
        return $this->belongsTo(TrackType::class, 'track_type_id');
    }

    public function pricingPlanType()
    {
        return $this->belongsTo(PricingPlanType::class, 'pricing_plan_type_id');
    }

    public function discount_plan(){
        return $this->belongsTo(DiscountPlan::class,'discount_plan_id','id');
    }
}
