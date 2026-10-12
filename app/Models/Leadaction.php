<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Leadaction extends CrmModel
{
    
        public function workflow(){
            return $this->belongsTo(WorkFlow::class,'workflow_id','id');
        }
}
