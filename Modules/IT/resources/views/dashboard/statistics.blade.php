@extends('layout.layout')
@section('content')
    <div class="app-bg">
        <div class="page-shell space-y-4">
            <x-page-title title="IT Ticket Statistics" />
            <dl class="d-flex gap-4 flex-wrap">
                @foreach(['total', 'open', 'pending', 'in_progress', 'closed'] as $field)
                    <div>
                        <dt>{{ ucwords(str_replace('_', ' ', $field)) }}</dt>
                        <dd>{{ $counts->{$field} ?? 0 }}</dd>
                    </div>
                @endforeach
                <div>
                    <dt>Overdue</dt>
                    <dd>{{ $overdueCount }}</dd>
                </div>
            </dl>
            <h2 class="fs-5">Active Priorities</h2>
            <table class="ui-table">
                <thead>
                    <tr>
                        <th>Priority</th>
                        <th>Tickets</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($priorities as $row)
                        <tr>
                            <td>{{ $row->name }}</td>
                            <td>{{ $row->total }}</td>
                    </tr>@endforeach
                </tbody>
            </table>
            @foreach(['Latest Tickets' => $latest, 'Overdue Tickets' => $overdue] as $title => $tickets)
                <h2 class="fs-5">{{ $title }}</h2>
                <table class="ui-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Requester</th>
                            <th>Assignee</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td>@can('it_tickets_show')<a
                                href="{{ route('it.tickets.show', $ticket->id) }}">{{ $ticket->title }}</a>@else{{ $ticket->title }}@endcan
                                </td>
                                <td>{{ $ticket->requester?->first_name }} {{ $ticket->requester?->last_name }}</td>
                                <td>{{ $ticket->assignedTo?->first_name }} {{ $ticket->assignedTo?->last_name }}</td>
                                <td>{{ $ticket->status }}</td>
                        </tr>@empty<tr>
                            <td colspan="4">No tickets found.</td>
                        </tr>@endforelse
                    </tbody>
                </table>
            @endforeach
        </div>
    </div>
@endsection