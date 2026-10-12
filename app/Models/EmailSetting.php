<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmailSetting extends CrmModel
{
    protected $fillable = ['role_id','send_email'];

    public function role()
    {
        return $this->belongsTo(Role::class,'role_id');
    }

}
