@extends('layout.layout')
@section('content')
    <div class="app-bg">
        <div class="page-shell">
            <x-page-title :title="$asset->name" />
            <dl>
                <dt>Product</dt>
                <dd>{{ $asset->product?->name }}</dd>
                <dt>Serial</dt>
                <dd>{{ $asset->serial_number }}</dd>
                <dt>Vendor</dt>
                <dd>{{ $asset->vendor?->name }}</dd>
                <dt>User</dt>
                <dd>{{ $asset->user?->full_name }}</dd>
                <dt>Total Cost</dt>
                <dd>{{ $asset->total_cost }}</dd>
            </dl>
            <table class="ui-table">
                <thead>
                    <tr>
                        <th>Accessory</th>
                        <th>Brand</th>
                        <th>Cost</th>
                        <th>Enabled</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($asset->accessories as $item)
                        <tr>
                            <td>{{ $item->type }}</td>
                            <td>{{ $item->brand }}</td>
                            <td>{{ $item->cost }}</td>
                            <td>{{ $item->enabled ? 'Yes' : 'No' }}</td>
                    </tr>@endforeach
                </tbody>
            </table><a href="{{ route('it.asset.index') }}">Back</a>
        </div>
    </div>
@endsection