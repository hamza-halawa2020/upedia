@extends('layout.layout')
@section('content')
<div class="app-bg"><div class="page-shell space-y-4">
    <x-page-title title="Manage IT Solutions">
        @can('it_solutions_create')<x-table-action type="create" :url="route('it.it-solutions.create')" label="Add Solution" />@endcan
    </x-page-title>
    @include('components.alert')
    @if($errors->any())<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
    <x-table-controls :action="route('it.it-solutions.index')" />
    <div class="ui-table-wrap"><table class="ui-table">
        <thead><tr><th>Title</th><th>Visibility</th><th>Departments</th><th>Actions</th></tr></thead>
        <tbody>
            @forelse($solutions as $solution)
                <tr><td>{{ $solution->title }}</td><td>{{ $solution->visibility }}</td>
                    <td>{{ $solution->departments->pluck('name')->join(', ') }}</td><td>
                    @can('it_solutions_show')<x-table-action type="view" :url="route('it.it-solutions.show', $solution->id)" />@endcan
                    @can('it_solutions_edit')<x-table-action type="edit" :url="route('it.it-solutions.edit', $solution->id)" />@endcan
                    @can('it_solutions_destroy')
                        <form class="d-inline" method="POST" action="{{ route('it.it-solutions.destroy', $solution->id) }}" onsubmit="return confirm('Delete this solution?')">
                            @csrf @method('DELETE')<x-table-action type="delete" buttonType="submit" />
                        </form>
                    @endcan
                </td></tr>
            @empty <tr><td colspan="4">No solutions found.</td></tr> @endforelse
        </tbody>
    </table></div>
    {{ $solutions->links() }}
</div></div>
@endsection
