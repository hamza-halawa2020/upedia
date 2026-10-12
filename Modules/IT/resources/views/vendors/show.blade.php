@extends('layout.layout')

@section('content')
<div class="app-bg"><div class="page-shell">
    <x-page-title :title="$vendor->name">
        @can('it_vendors_edit')
            <x-table-action type="edit" :url="route('it.vendors.edit', $vendor->id)" />
        @endcan
    </x-page-title>
    <dl>
        <dt>Phone</dt><dd>{{ $vendor->phone }}</dd>
        <dt>Location</dt><dd>{{ $vendor->location }}</dd>
        <dt>Tax (%)</dt><dd>{{ $vendor->tax ?? 0 }}</dd>
        <dt>Shipping Cost</dt><dd>{{ $vendor->shipping_cost ?? 0 }}</dd>
    </dl>
    <a href="{{ route('it.vendors.index') }}" class="btn btn-outline-secondary">Back</a>
</div></div>
@endsection
