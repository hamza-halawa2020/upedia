<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    protected $fillable = ['name', 'parent_id', 'priority_id'];
    protected $table = 'ticket_categories';

    public function parent()
    {
        return $this->belongsTo(TicketCategory::class, 'parent_id');
    }

    public function priority()
    {
        return $this->belongsTo(TicketPriority::class, 'priority_id');
    }

    public function children()
    {
        return $this->hasMany(TicketCategory::class, 'parent_id');
    }

    public function items()
    {
        return $this->hasMany(TicketItem::class, 'ticket_subcategory_id');
    }
}
