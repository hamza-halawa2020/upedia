<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketPriority extends Model
{
    protected $table = 'ticket_priorities';

    protected $fillable = [
        'name',
        'sla_hours'
    ];

    public function categories()
{
    return $this->hasMany(TicketCategory::class, 'priority_id');
}

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
