@extends('layout.layout')
@section('content')
<div class="app-bg"><div class="page-shell space-y-4">
    <x-page-title title="IT Saved Tables" />
    @include('components.alert')
    <div class="ui-table-wrap"><table class="ui-table">
        <thead><tr><th>Table</th><th>File</th><th>Rows</th><th>Created</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($tables as $table)
                <tr><td>{{ $table->table_name }}</td><td>{{ $table->file_name }}</td>
                    <td>{{ $table->total_rows }}</td><td>{{ $table->created_at?->format('Y-m-d H:i') }}</td><td>
                    <x-table-action type="view" :url="route('it.filtered_tables.view', $table->id)" />
                    <a href="{{ route('it.filtered_tables.restore', $table->id) }}" class="btn btn-outline-secondary btn-sm" title="Restore filters">
                        <iconify-icon icon="lucide:rotate-ccw"></iconify-icon>
                    </a>
                    <form class="d-inline" method="POST" action="{{ route('it.filtered_tables.destroy', $table->id) }}" onsubmit="return confirm('Delete this saved table?')">
                        @csrf @method('DELETE')<x-table-action type="delete" buttonType="submit" />
                    </form>
                </td></tr>
            @empty <tr><td colspan="5">No saved tables found.</td></tr> @endforelse
        </tbody>
    </table></div>
    {{ $tables->links() }}
</div></div>
@endsection
