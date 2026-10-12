<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Reason extends CrmModel
{

    protected $table = 'crm_reasons';

    protected $fillable = [
        'reason',
    ];

    public function calls(){
        return $this->hasMany(Call::class);
    }
}
