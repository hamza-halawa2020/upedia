<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketItem extends Model
{
    protected $guarded = [];

    public function subcategory()
    {
        return $this->belongsTo(TicketCategory::class, 'ticket_subcategory_id');
    }

    public function category()
    {
        return $this->subcategory();
    }
}
