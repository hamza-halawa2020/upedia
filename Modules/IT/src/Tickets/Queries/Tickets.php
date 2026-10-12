<?php

namespace Modules\IT\Tickets\Queries;

use App\Models\Staff;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketItem;
use App\Models\TicketPriority;
use Modules\IT\Tickets\Filters\TicketFilters;

class Tickets
{
    public function __construct(private readonly TicketFilters $filters) {}

    public function query(array $data = [])
    {
        return $this->filters->apply(Ticket::with(['category', 'subcategory', 'item', 'ticketPriority',
            'requester:id,first_name,last_name', 'assignedTo:id,first_name,last_name', 'creator:id,full_name']), $data)->latest('id');
    }

    public function list(array $data)
    {
        return $this->query($data)->paginate($data['per_page'] ?? 10)->withQueryString();
    }

    public function find(int $id): Ticket
    {
        return $this->query()->with('attachments')->findOrFail($id);
    }

    public function options(): array
    {
        return ['categories' => TicketCategory::with('parent')->get(),
            'items' => TicketItem::all(), 'priorities' => TicketPriority::all(),
            'staffs' => Staff::orderBy('first_name')->get(['id', 'first_name', 'last_name'])];
    }
}
