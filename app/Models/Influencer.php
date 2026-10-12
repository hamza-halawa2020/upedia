<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Influencer extends Model
{
    protected $table = 'influencers';

    protected $fillable = [
        'name', 'phone', 'email', 'user_id', 'influencer_type', 'created_by',
    ];

    public function promocodes()
    {
        return $this->hasMany(Promocode::class, 'influencer_id');
    }
}