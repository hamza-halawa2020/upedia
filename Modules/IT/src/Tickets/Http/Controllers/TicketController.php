<?php

namespace Modules\IT\Tickets\Http\Controllers;

use App\Actions\Exports\DownloadExport;
use App\Models\Ticket;
use App\Support\Api\ApiResponse;
use Illuminate\Routing\Controller;
use Modules\IT\SavedTables\Actions\SaveExportTable;
use Modules\IT\Tickets\Actions\DeleteTicket;
use Modules\IT\Tickets\Actions\SaveTicket;
use Modules\IT\Tickets\Exports\TicketsExport;
use Modules\IT\Tickets\Http\Requests\ListTicketsRequest;
use Modules\IT\Tickets\Http\Requests\SaveTicketRequest;
use Modules\IT\Tickets\Queries\Tickets;
use Modules\IT\Tickets\Queries\TicketStaff;

class TicketController extends Controller
{
    public function __construct()
    {
        $this->middleware('check.permission:it_tickets_index')->only(['index', 'export', 'saveFilteredTable']);
        $this->middleware('check.permission:it_tickets_create')->only(['create', 'store', 'getStaffByDepartment', 'searchStaff', 'getStaffDetails']);
        $this->middleware('check.permission:it_tickets_show')->only('show');
        $this->middleware('check.permission:it_tickets_edit')->only(['edit', 'update']);
        $this->middleware('check.permission:it_tickets_destroy')->only('destroy');
    }

    public function index(ListTicketsRequest $request, Tickets $query)
    {
        return view('it::tickets.index', ['tickets' => $query->list($request->validated())]);
    }

    public function create(Tickets $query)
    {
        return view('it::tickets.form', ['ticket' => null] + $query->options());
    }

    public function store(SaveTicketRequest $request, SaveTicket $save)
    {
        $save->handle($request->validated(), $request->user()->id);

        return redirect()->route('it.tickets.index')->with('success', 'Ticket created.');
    }

    public function show(int $ticket, Tickets $query)
    {
        return view('it::tickets.show', ['ticket' => $query->find($ticket)]);
    }

    public function edit(int $ticket, Tickets $query)
    {
        return view('it::tickets.form', ['ticket' => $query->find($ticket)] + $query->options());
    }

    public function update(SaveTicketRequest $request, int $ticket, SaveTicket $save)
    {
        $save->handle($request->validated(), $request->user()->id, $ticket);

        return redirect()->route('it.tickets.index')->with('success', 'Ticket updated.');
    }

    public function destroy(int $ticket, DeleteTicket $delete)
    {
        $delete->handle($ticket);

        return redirect()->route('it.tickets.index')->with('success', 'Ticket deleted.');
    }

    public function getStaffByDepartment(int $departmentId, TicketStaff $staff)
    {
        return ApiResponse::success(['data' => $staff->department($departmentId)]);
    }

    public function searchStaff(ListTicketsRequest $request, TicketStaff $staff)
    {
        return ApiResponse::success(['data' => $staff->search($request->validated('q', '') ?? '')]);
    }

    public function getStaffDetails(int $staffId, TicketStaff $staff)
    {
        return ApiResponse::success(['data' => $staff->details($staffId)]);
    }

    public function export(ListTicketsRequest $request)
    {
        return app(DownloadExport::class)->handle(new TicketsExport($request->validated()), 'tickets', $request->validated('format', 'xlsx'));
    }

    public function saveFilteredTable(ListTicketsRequest $request, Tickets $query, SaveExportTable $save)
    {
        $criteria = $request->safe()->except(['format', 'per_page', 'q']);
        $save->handle(new TicketsExport($criteria), 'Tickets', Ticket::class, $criteria, $query->query($criteria)->count());

        return redirect()->route('it.filtered_tables.index')->with('success', 'Ticket table saved.');
    }
}
