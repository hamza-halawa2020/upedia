<?php

namespace Modules\IT\TicketConfiguration;

use App\Models\TicketCategory;
use App\Models\TicketItem;
use App\Models\TicketPriority;

enum Catalog: string
{
    case Categories = 'ticket-categories';
    case Items = 'ticket-items';
    case Priorities = 'ticket-priorities';

    public function model(): string
    {
        return match ($this) {
            self::Categories => TicketCategory::class,
            self::Items => TicketItem::class,
            self::Priorities => TicketPriority::class,
        };
    }

    public function title(): string
    {
        return match ($this) {
            self::Categories => 'Ticket Categories',
            self::Items => 'Ticket Items',
            self::Priorities => 'Ticket Priorities',
        };
    }

    public function relationships(): array
    {
        return match ($this) {
            self::Categories => ['parent', 'priority'],
            self::Items => ['subcategory.parent'],
            self::Priorities => [],
        };
    }
}
