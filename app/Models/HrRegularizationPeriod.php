<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HrRegularizationPeriod extends Model
{
   protected  $table = "hr_regularizations_periods";
   protected $guarded =  [];
   public  $timestamps = true;


   public function HrRegularizationPermission()
   {
       return $this->belongsTo(HrRegularizationPermission::class,'hr_regularization_permission_id' , 'id');
   }


}
