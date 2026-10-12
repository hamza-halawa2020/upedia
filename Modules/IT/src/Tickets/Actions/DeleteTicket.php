<?php

namespace Modules\IT\Tickets\Actions;

use App\Models\Ticket;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class DeleteTicket
{
    public function handle(int $id): void
    {
        DB::transaction(function () use ($id) {
            $ticket = Ticket::lockForUpdate()->findOrFail($id);
            app(\App\Actions\Attachments\DeleteAttachments::class)->handle($ticket);
            $ticket->delete();
        });
    }
}
