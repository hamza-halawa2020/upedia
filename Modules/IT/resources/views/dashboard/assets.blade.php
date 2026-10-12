@extends('layout.layout')
@section('content')
    <div class="app-bg">
        <div class="page-shell space-y-4">
            <x-page-title title="Asset Statistics" />
            <dl class="d-flex gap-4 flex-wrap">@foreach(['total', 'in_use', 'in_store', 'in_repair'] as $field)
                <div>
                    <dt>{{ ucwords(str_replace('_', ' ', $field)) }}</dt>
                    <dd>{{ $summary->{$field} ?? 0 }}</dd>
                </div>
            @endforeach
            </dl>
            <table class="ui-table">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Total</th>
                        <th>In Use</th>
                        <th>In Store</th>
                        <th>In Repair</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($groups as $group)
                        <tr>
                            <td>{{ $group->name }}</td>
                            <td>{{ $group->total }}</td>
                            <td>{{ $group->in_use }}</td>
                            <td>{{ $group->in_store }}</td>
                            <td>{{ $group->in_repair }}</td>
                        </tr>
                    @empty<tr>
                        <td colspan="5">No assets found.</td>
                    </tr>@endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection