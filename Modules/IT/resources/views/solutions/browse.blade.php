@extends('layout.layout')
@section('content')
<div class="app-bg"><div class="page-shell space-y-4">
    <x-page-title title="IT Solutions" />
    <x-table-controls :action="route('it.solutions.browse')">
        <select name="sort" class="form-select" aria-label="Sort solutions" onchange="this.form.submit()">
            @foreach(['latest' => 'Latest', 'popular' => 'Popular', 'az' => 'A-Z'] as $value => $label)
                <option value="{{ $value }}" @selected(request('sort', 'latest') === $value)>{{ $label }}</option>
            @endforeach
        </select>
    </x-table-controls>
    <div class="ui-table-wrap"><table class="ui-table">
        <thead class="ui-table__head"><tr><th>Title</th><th>Topic</th><th>Departments</th><th></th></tr></thead>
        <tbody class="ui-table__body">
            @forelse($solutions as $solution)
                <tr><td>{{ $solution->title }}</td><td>{{ $solution->topic_name }}</td>
                    <td>{{ $solution->departments->pluck('name')->join(', ') }}</td>
                    <td><x-table-action type="view" :url="route('it.solutions.view', $solution->id)" /></td></tr>
            @empty
                <tr><td colspan="4">No solutions found.</td></tr>
            @endforelse
        </tbody>
    </table></div>
    {{ $solutions->links() }}
</div></div>
@endsection
