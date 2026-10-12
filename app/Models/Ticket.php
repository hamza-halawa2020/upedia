<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

use App\Traits\Viewable;

class Ticket extends Model
{
    use Viewable;

    protected $guarded = [];
    public function category()
    {
        return $this->belongsTo(TicketCategory::class, 'ticket_category_id');
    }
    public function subcategory()
    {
        return $this->belongsTo(TicketCategory::class, 'ticket_subcategory_id');
    }
    public function item()
    {
        return $this->belongsTo(TicketItem::class, 'ticket_item_id');
    }
    public function ticketPriority()
    {
        return $this->belongsTo(TicketPriority::class, 'ticket_priority_id');
    }
    public function requester()
    {
        return $this->belongsTo(Staff::class, 'requester_id');
    }
    public function assignedTo()
    {
        return $this->belongsTo(Staff::class, 'assigned_to');
    }
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function scopeBreachedSla(Builder $query): Builder
    {
        return $query
            ->where('status', '!=', 'closed')
            ->whereHas('ticketPriority', function (Builder $priorityQuery) {
                $priorityQuery
                    ->whereNotNull('sla_hours')
                    ->whereRaw('DATE_ADD(tickets.created_at, INTERVAL ticket_priorities.sla_hours HOUR) < NOW()');
            });
    }
    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachable', 'model_type', 'model_id');
    }
}
