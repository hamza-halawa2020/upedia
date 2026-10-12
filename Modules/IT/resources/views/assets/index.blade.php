@extends('layout.layout')
@section('content')
    <div class="app-bg">
        <div class="page-shell space-y-4">
            <x-page-title title="IT Assets">@can('it_assets_create')<x-table-action type="create"
            :url="route('it.asset.create')" label="Add Asset" />@endcan</x-page-title>
            @include('components.alert')
            <x-table-controls :action="route('it.asset.index')" :filters="['status' => ['in_use' => 'In Use', 'in_store' => 'In Store', 'in_repair' => 'In Repair']]" :date="true">
                <button class="btn btn-outline-success" formaction="{{ route('it.asset.export') }}" name="format"
                    value="xlsx">Excel</button>
                <button class="btn btn-outline-success" formaction="{{ route('it.asset.export') }}" name="format"
                    value="csv">CSV</button>
                <button class="btn btn-outline-primary" formaction="{{ route('it.asset.saveFilteredTable') }}"
                    title="Save table"><iconify-icon icon="lucide:save"></iconify-icon></button>
            </x-table-controls>
            <div class="ui-table-wrap">
                <table class="ui-table">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Product</th>
                            <th>Serial</th>
                            <th>Total Cost</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($assets as $asset)
                            <tr>
                                <td>{{ $asset->name }}</td>
                                <td>{{ $asset->product?->name }}</td>
                                <td>{{ $asset->serial_number }}</td>
                                <td>{{ $asset->total_cost }}</td>
                                <td>{{ $asset->is_currently_in_use }}</td>
                                <td>
                                    @can('it_assets_show')<x-table-action type="view" :url="route('it.asset.show', $asset->id)" />@endcan
                                    @can('it_assets_edit')<x-table-action type="edit" :url="route('it.asset.edit', $asset->id)" />@endcan
                                    @can('it_assets_destroy')
                                        <form method="POST" class="d-inline" action="{{ route('it.asset.destroy', $asset->id) }}"
                                            onsubmit="return confirm('Delete this asset and accessories?')">
                                            @csrf @method('DELETE')<x-table-action type="delete" buttonType="submit" />
                                    </form>@endcan
                                </td>
                        </tr>@empty <tr>
                            <td colspan="6">No assets found.</td>
                        </tr>@endforelse
                    </tbody>
                </table>
            </div>{{ $assets->links() }}
        </div>
    </div>
@endsection