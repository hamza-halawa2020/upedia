<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrmLead extends Model
{
    use HasFactory;
    protected $table = 'crm_leads';
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone',
        'industry',
        'address',
        'position ',
        'assigned_to',
        'creator_id',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'creator_id');
    }
}
