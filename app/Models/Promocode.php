<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Promocode extends Model
{
    protected $table = 'promocodes';

    protected $fillable = [
        'code',
        'limit',
        'type', 
        'discount', 
        'is_monthly_renewable', 
        'created_by',
        'expire_date',
        'influencer_id',
        'commission_type',
        'commission_amount',
    ];

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function studentInvoices()
    {
        return $this->hasMany(FinanaceStudentInvoice::class, 'promocode_id');
    }

    public function influencer()
    {
        return $this->belongsTo(Influencer::class, 'influencer_id');
    }
}
