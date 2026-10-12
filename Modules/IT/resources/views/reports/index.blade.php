@extends('layout.layout')
@section('content')
    <div class="app-bg">
        <div class="page-shell space-y-4">
            <x-page-title title="IT Reports" />
            <form method="GET" action="{{ route('it.reports.index') }}" class="d-flex gap-3 flex-wrap">
                <select name="range" class="form-select w-auto" aria-label="Report range">
                    @foreach(['day' => 'Today', 'week' => 'Last 7 Days', 'month' => 'Last 30 Days'] as $value => $label)
                        <option value="{{ $value }}" @selected(request('range', 'month') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                <input type="date" name="date_from" class="form-control w-auto" aria-label="From"
                    value="{{ request('date_from') }}">
                <input type="date" name="date_to" class="form-control w-auto" aria-label="To"
                    value="{{ request('date_to') }}">
                <button type="submit" class="btn btn-outline-primary" title="Apply filters"><iconify-icon
                        icon="lucide:filter"></iconify-icon></button>
            </form>
            @if($errors->any())
                <ul>@foreach($errors->all() as $error)
                <li>{{ $error }}</li>@endforeach
            </ul>@endif
            <p>{{ $start->format('Y-m-d') }} to {{ $end->format('Y-m-d') }}</p>
            @can('it_tickets_index')
                <nav class="d-flex gap-3 flex-wrap" aria-label="Report details">
                    @foreach($links as $label => $url)<a href="{{ $url }}">{{ $label }}</a>@endforeach
                </nav>
            @endcan
            @if($topDepartment)
            <p>Top Department: {{ $topDepartment->name }}</p>@endif
            <h2 class="fs-5">Ticket Summary</h2>
            <dl class="d-flex gap-4 flex-wrap">@foreach($totalStats as $key => $value)
                <div>
                    <dt>{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                    <dd>{{ $value }}</dd>
                </div>
            @endforeach
            </dl>
            <h2 class="fs-5">Live Overview</h2>
            <dl class="d-flex gap-4 flex-wrap">@foreach($realTimeData as $key => $value)
                <div>
                    <dt>{{ ucwords(str_replace('_', ' ', $key)) }}</dt>
                    <dd>{{ $value }}</dd>
                </div>
            @endforeach
            </dl>
            @include('it::reports.partials.table', ['title' => 'Classification', 'rows' => $classification, 'columns' => ['name' => 'Category', 'total' => 'Tickets', 'percentage' => 'Share (%)']])
            @include('it::reports.partials.table', ['title' => 'Department Performance', 'rows' => $departmentPerformance, 'columns' => ['name' => 'Department', 'total_tickets' => 'Tickets', 'load_ratio' => 'Relative Load (%)']])
            <h2 class="fs-5">Resolution Times</h2>
            <dl class="d-flex gap-4 flex-wrap">@foreach(['average', 'fastest', 'slowest'] as $key)
                <div>
                    <dt>{{ ucfirst($key) }}</dt>
                    <dd>{{ $resolutionMetrics[$key] }}</dd>
                </div>
            @endforeach
            </dl>
            @foreach(['fastest_ticket' => 'Fastest Ticket', 'slowest_ticket' => 'Slowest Ticket'] as $key => $label)
                @if($resolutionMetrics[$key])
                    <p>{{ $label }}: @can('it_tickets_show')<a
                    href="{{ route('it.tickets.show', $resolutionMetrics[$key]->id) }}">{{ $resolutionMetrics[$key]->title }}</a>@else{{ $resolutionMetrics[$key]->title }}@endcan
                </p>@endif
            @endforeach
            @include('it::reports.partials.table', ['title' => 'Recurring Issues', 'rows' => $recurringIssues, 'columns' => ['label' => 'Issue', 'total' => 'Tickets']])
            <h2 class="fs-5">Time Patterns</h2>
            <p>Peak Day: {{ $timePatterns['peak_day'] }}. Peak Hour: {{ $timePatterns['peak_hour'] }}.</p>
            @include('it::reports.partials.table', ['title' => 'Days', 'rows' => $timePatterns['days'], 'columns' => ['label' => 'Day', 'total' => 'Tickets']])
            @include('it::reports.partials.table', ['title' => 'Hours', 'rows' => $timePatterns['hours'], 'columns' => ['label' => 'Hour', 'total' => 'Tickets']])
            <h2 class="fs-5">Internet / Network Issues</h2>
            <p>Total: {{ $internetPattern['total'] }}. Peak Day: {{ $internetPattern['peak_day'] }}. Peak Hour:
                {{ $internetPattern['peak_hour'] }}.
            </p>
            @include('it::reports.partials.table', ['title' => 'Reopened Tickets', 'rows' => $reopenedIssues, 'columns' => ['title' => 'Ticket', 'reopen_count' => 'Reopened', 'status' => 'Status']])
            @include('it::reports.partials.table', ['title' => 'Resolution Notes', 'rows' => $resolutionDescriptions, 'columns' => ['title' => 'Ticket', 'resolution_description' => 'Resolution']])
            @foreach($charts as $name => $chart)
                <x-report-chart :chart="$chart" :title="ucfirst($name) . ' Trend'" :id="'it-report-' . $name" />
                @include('it::reports.partials.table', [
                    'title' => ucfirst($name) . ' Trend',
                    'rows' => collect($chart['labels'])->map(fn($label, $index) => ['label' => $label, 'total' => $chart['values'][$index]]),
                    'columns' => ['label' => 'Period / Group', 'total' => 'Tickets']
                ])
            @endforeach
        </div>
    </div>
@endsection