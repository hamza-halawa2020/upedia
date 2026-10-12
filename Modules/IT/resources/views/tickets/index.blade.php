@extends('layout.layout')
@section('content')
    <div class="app-bg">
        <div class="page-shell space-y-4">
            <x-page-title title="IT Tickets">@can('it_tickets_create')<x-table-action type="create"
            :url="route('it.tickets.create')" label="Add Ticket" />@endcan</x-page-title>
            @include('components.alert')
            <x-table-controls :action="route('it.tickets.index')" :date="true" :filters="['status' => ['open' => 'Open', 'pending' => 'Pending', 'in_progress' => 'In Progress', 'closed' => 'Closed']]">
                <button class="btn btn-outline-success" formaction="{{ route('it.tickets.export') }}" name="format"
                    value="xlsx">Excel</button>
                <button class="btn btn-outline-success" formaction="{{ route('it.tickets.export') }}" name="format"
                    value="csv">CSV</button>
                <button class="btn btn-outline-primary" formaction="{{ route('it.tickets.saveFilteredTable') }}"
                    title="Save table"><iconify-icon icon="lucide:save"></iconify-icon></button>
                <button type="submit" class="btn btn-outline-success" formaction="{{ route('it.tickets.export') }}"
                    name="format" value="pdf">PDF</button>
            </x-table-controls>
            @if($errors->any())
                <ul>@foreach($errors->all() as $error)
                <li>{{ $error }}</li>@endforeach
            </ul>@endif
            <div class="ui-table-wrap">
                <table class="ui-table">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Category</th>
                            <th>Requester</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tickets as $ticket)
                            <tr>
                                <td>{{ $ticket->title }}</td>
                                <td>{{ $ticket->category?->name }}</td>
                                <td>{{ $ticket->requester?->first_name }} {{ $ticket->requester?->last_name }}</td>
                                <td>{{ $ticket->status }}</td>
                                <td>
                                    @can('it_tickets_show')<x-table-action type="view" :url="route('it.tickets.show', $ticket->id)" />@endcan
                                    @can('it_tickets_edit')<x-table-action type="edit" :url="route('it.tickets.edit', $ticket->id)" />@endcan
                                    @can('it_tickets_destroy')
                                        <form class="d-inline" method="POST" action="{{ route('it.tickets.destroy', $ticket->id) }}"
                                            onsubmit="return confirm('Delete this ticket?')">
                                            @csrf @method('DELETE')<x-table-action type="delete" buttonType="submit" />
                                    </form>@endcan
                                </td>
                        </tr>@empty<tr>
                            <td colspan="5">No tickets found.</td>
                        </tr>@endforelse
                    </tbody>
                </table>
            </div>{{ $tickets->links() }}
        </div>
    </div>
@endsection