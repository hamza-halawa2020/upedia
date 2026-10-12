@extends('layout.layout')
@section('content')
<div class="app-bg"><div class="page-shell space-y-4">
    <x-page-title title="IT Purchases">
        @can('it_purchase_create')<x-table-action type="create" :url="route('it.purchase.create')" label="Add Purchase" />@endcan
    </x-page-title>
    @include('components.alert')
    <form method="GET" action="{{ route('it.purchase.index') }}" class="d-flex gap-2 flex-wrap">
        <input name="purchase_number" class="form-control w-auto" aria-label="Purchase number" placeholder="Purchase number" value="{{ request('purchase_number') }}">
        <select name="status" class="form-select w-auto" aria-label="Status"><option value="">All statuses</option>
            @foreach(['pending', 'approved', 'rejected', 'completed', 'purchased'] as $status)
                <option @selected(request('status') === $status)>{{ $status }}</option>
            @endforeach
        </select>
        <button class="btn btn-outline-secondary" title="Search"><iconify-icon icon="lucide:search"></iconify-icon></button>
        <button class="btn btn-outline-success" formaction="{{ route('it.purchase.export') }}" name="format" value="xlsx">Excel</button>
        <button class="btn btn-outline-success" formaction="{{ route('it.purchase.export') }}" name="format" value="csv">CSV</button>
        <button class="btn btn-outline-primary" formaction="{{ route('it.purchase.saveFilteredTable') }}" title="Save filtered table"><iconify-icon icon="lucide:save"></iconify-icon></button>
    </form>
    @if($errors->any())<ul>@foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>@endif
    <div class="ui-table-wrap"><table class="ui-table"><thead><tr><th>Number</th><th>Name</th><th>Status</th><th>Total</th><th>Actions</th></tr></thead><tbody>
        @forelse($purchases as $purchase)
            <tr><td>{{ $purchase->purchase_number }}</td><td>{{ $purchase->name }}</td><td>{{ $purchase->status }}</td><td>{{ $purchase->total }}</td><td>
                @can('it_purchase_show')<x-table-action type="view" :url="route('it.purchase.show', $purchase->id)" />@endcan
                @if($purchase->status === 'pending')
                    @can('it_purchase_edit')<x-table-action type="edit" :url="route('it.purchase.edit', $purchase->id)" />@endcan
                    @can('it_purchase_destroy')<form class="d-inline" method="POST" action="{{ route('it.purchase.destroy', $purchase->id) }}" onsubmit="return confirm('Delete this purchase?')">
                        @csrf @method('DELETE')<x-table-action type="delete" buttonType="submit" />
                    </form>@endcan
                @endif
            </td></tr>
        @empty <tr><td colspan="5">No purchases found.</td></tr> @endforelse
    </tbody></table></div>
    {{ $purchases->links() }}
</div></div>
@endsection
