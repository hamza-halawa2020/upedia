<dl class="d-flex gap-4 flex-wrap">
    <div>
        <dt>Closed Today</dt>
        <dd>{{ $closedToday }}</dd>
    </div>
    <div>
        <dt>Reopened This Week</dt>
        <dd>{{ $reopenedWeek }}</dd>
    </div>
</dl>
<h2 class="fs-5">IT Workload: Last 7 Days</h2>
<table class="ui-table">
    <thead>
        <tr>
            <th>Staff</th>
            <th>Open</th>
            <th>Pending</th>
            <th>In Progress</th>
            <th>Closed</th>
            <th>Total</th>
        </tr>
    </thead>
    <tbody>
        @forelse($workload as $row)
            <tr>@foreach(['name', 'open', 'pending', 'in_progress', 'closed', 'total'] as $field)
            <td>{{ $row[$field] }}</td>@endforeach
            </tr>
        @empty
            <tr>
                <td colspan="6">No IT staff found.</td>
            </tr>
        @endforelse
    </tbody>
</table>
@if($assetSummary)
    <h2 class="fs-5">Assets</h2>
    <dl class="d-flex gap-4 flex-wrap">
        @foreach(['total', 'in_use', 'in_store', 'in_repair'] as $field)
            <div>
                <dt>{{ ucwords(str_replace('_', ' ', $field)) }}</dt>
                <dd>{{ $assetSummary->{$field} ?? 0 }}</dd>
            </div>
        @endforeach
    </dl>
@endif