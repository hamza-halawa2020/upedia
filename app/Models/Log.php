<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Log extends CrmModel
{

    
    protected $fillable = [
        'name',
        'description',
        'related_type',
        'related_id',
        'action_type',
        'action_id',
        'user_id',
    ];
   
    //start relationships
        public function lead(){
            return $this->belongsToMany(Lead::class);
        }
        public function call(){
            return $this->belongsToMany(Call::class);
        }
        public function task(){
            return $this->belongsToMany(Task::class);
        }
        public function action()
        {
            return $this->morphTo();
        }
        public function related()
        {
            return $this->morphTo();
        }
        public function user(){
            return $this->belongsTo(User::class);
        }
    //end relationships
  
}
