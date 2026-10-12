@extends('layout.layout')

@section('content')
<div class="app-bg"><div class="page-shell space-y-4">
    <x-page-title title="IT Vendors">
        @can('it_vendors_create')
            <x-table-action type="create" :url="route('it.vendors.create')" label="Add Vendor" />
        @endcan
    </x-page-title>
    @include('components.alert')
    <x-table-controls :action="route('it.vendors.index')">
        <a class="btn btn-outline-success btn-sm" title="Export Excel"
            href="{{ route('it.vendors.export', ['search' => request('search'), 'format' => 'xlsx']) }}">
            <iconify-icon icon="lucide:download"></iconify-icon> Excel
        </a>
        <a class="btn btn-outline-success btn-sm" title="Export CSV"
            href="{{ route('it.vendors.export', ['search' => request('search'), 'format' => 'csv']) }}">
            <iconify-icon icon="lucide:download"></iconify-icon> CSV
        </a>
    </x-table-controls>
    <div class="ui-table-wrap nice-scrollbar"><table class="ui-table">
        <thead class="ui-table__head"><tr>
            <th>Vendor</th><th>Phone</th><th>Location</th><th>Tax (%)</th><th>Shipping</th><th>Actions</th>
        </tr></thead>
        <tbody class="ui-table__body">
            @forelse($vendors as $vendor)
                <tr>
                    <td>{{ $vendor->name }}</td><td>{{ $vendor->phone }}</td><td>{{ $vendor->location }}</td>
                    <td>{{ $vendor->tax ?? 0 }}</td><td>{{ $vendor->shipping_cost ?? 0 }}</td>
                    <td>
                        @can('it_vendors_show')
                            <x-table-action type="view" :url="route('it.vendors.show', $vendor->id)" />
                        @endcan
                        @can('it_vendors_edit')
                            <x-table-action type="edit" :url="route('it.vendors.edit', $vendor->id)" />
                        @endcan
                        @can('it_vendors_destroy')
                            <form action="{{ route('it.vendors.destroy', $vendor->id) }}" method="POST"
                                class="d-inline" onsubmit="return confirm('Delete this vendor and all its assets?')">
                                @csrf
                                @method('DELETE')
                                <x-table-action type="delete" buttonType="submit" />
                            </form>
                        @endcan
                    </td>
                </tr>
            @empty
                <tr><td colspan="6" class="text-center">No vendors found.</td></tr>
            @endforelse
        </tbody>
    </table></div>
    {{ $vendors->links() }}
</div></div>
@endsection
