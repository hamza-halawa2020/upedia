@extends('layout.layout')
@section('content')
<div class="app-bg"><div class="page-shell space-y-4">
    <x-page-title :title="$catalog->title()">
        <x-table-action type="create" :url="route('it.'.$catalog->value.'.create')" label="Add" />
    </x-page-title>
    @include('components.alert')
    <nav class="d-flex gap-3">
        @foreach(\Modules\IT\TicketConfiguration\Catalog::cases() as $tab)
            <a href="{{ route('it.'.$tab->value.'.index') }}" @if($tab === $catalog) aria-current="page" @endif>{{ $tab->title() }}</a>
        @endforeach
    </nav>
    <x-table-controls :action="route('it.'.$catalog->value.'.index')" />
    <div class="ui-table-wrap"><table class="ui-table">
        <thead class="ui-table__head"><tr><th>Name</th><th>Category / SLA</th><th>Actions</th></tr></thead>
        <tbody class="ui-table__body">
            @forelse($records as $record)
                <tr><td>{{ $record->name }}</td><td>
                    @switch($catalog->value)
                        @case('ticket-categories') {{ $record->parent?->name ?? 'Main category' }} @break
                        @case('ticket-items') {{ $record->subcategory?->name }} @break
                        @case('ticket-priorities') {{ $record->sla_hours }} hours @break
                    @endswitch
                </td><td>
                    <x-table-action type="view" :url="route('it.'.$catalog->value.'.show', $record->id)" />
                    <x-table-action type="edit" :url="route('it.'.$catalog->value.'.edit', $record->id)" />
                    <form class="d-inline" method="POST" action="{{ route('it.'.$catalog->value.'.destroy', $record->id) }}"
                        onsubmit="return confirm('Delete this record?')">
                        @csrf @method('DELETE')
                        <x-table-action type="delete" buttonType="submit" />
                    </form>
                </td></tr>
            @empty
                <tr><td colspan="3">No records found.</td></tr>
            @endforelse
        </tbody>
    </table></div>
    {{ $records->links() }}
</div></div>
@endsection
