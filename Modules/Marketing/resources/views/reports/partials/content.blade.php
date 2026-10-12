    <div class="container-fluid py-3">
        <div class="report-shell">
            <div class="report-box mb-3">
                <div class="d-flex flex-wrap justify-content-between align-items-start gap-3">
                    <div>
                        <div class="small text-uppercase mb-2">Marketing Control Center</div>
                        <div class="h4 mb-2">Marketing Reports Dashboard</div>
                        <p class="mb-0">{{ $rangeLabel }}</p>
                    </div>
                    <div class="report-toolbar">
                        <div class="mb-3">
                            <form method="GET" action="{{ route('reports.index') }}" class="row g-2 align-items-end">
                                <div class="col-sm-5">
                                    <label class="form-label small mb-1" for="report-from">From</label>
                                    <input id="report-from" type="date" name="from" value="{{ $from }}"
                                        class="form-control">
                                </div>
                                <div class="col-sm-5">
                                    <label class="form-label small mb-1" for="report-to">To</label>
                                    <input id="report-to" type="date" name="to" value="{{ $to }}"
                                        class="form-control">
                                </div>
                                <div class="col-sm-2">
                                    <button type="submit" class="btn btn-dark w-100">Apply</button>
                                </div>
                            </form>
                        </div>
                        <div class="quick-filters">
                            <a href="{{ route('reports.index', ['from' => $quickRanges['today']['from'], 'to' => $quickRanges['today']['to']]) }}"
                                class="btn btn-sm {{ $from === $quickRanges['today']['from'] && $to === $quickRanges['today']['to'] ? 'btn-dark' : 'btn-outline-secondary' }}">
                                Today
                            </a>
                            <a href="{{ route('reports.index', ['from' => $quickRanges['last7']['from'], 'to' => $quickRanges['last7']['to']]) }}"
                                class="btn btn-sm {{ $from === $quickRanges['last7']['from'] && $to === $quickRanges['last7']['to'] ? 'btn-dark' : 'btn-outline-secondary' }}">
                                Last 7 Days
                            </a>
                            <a href="{{ route('reports.index', ['from' => $quickRanges['last30']['from'], 'to' => $quickRanges['last30']['to']]) }}"
                                class="btn btn-sm {{ $from === $quickRanges['last30']['from'] && $to === $quickRanges['last30']['to'] ? 'btn-dark' : 'btn-outline-secondary' }}">
                                Last 30 Days
                            </a>
                            <a href="{{ route('reports.index') }}" class="btn btn-sm btn-outline-secondary">Reset</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row g-3">
                <div class="col-lg-3">
                    <div class="report-sidebar">
                        @foreach ($sections as $key => $section)
                            <button type="button" class="tab-link{{ $loop->first ? ' active' : '' }}"
                                data-tab="{{ $key }}">
                                {{ $section['title'] }}
                            </button>
                        @endforeach
                    </div>
                </div>

                <div class="col-lg-9">
                    @foreach ($sections as $key => $section)
                        <div id="tab-{{ $key }}" class="tab-pane-panel{{ $loop->first ? ' active' : '' }}">
                            <div class="section-head">
                         
                            </div>

                            @if ($key === 'overview')
                                <div class="metric-grid">
                                    @foreach ($summaryCards as $card)
                                        @if (!empty($card['url']))
                                            <a href="{{ $card['url'] }}" class="metric-tile">
                                                <span class="metric-label">{{ $card['label'] }}</span>
                                                <span class="metric-value">{{ $card['value'] }}</span>
                                                <span class="metric-meta">{{ $card['meta'] }}</span>
                                            </a>
                                        @else
                                            <div class="metric-tile">
                                                <span class="metric-label">{{ $card['label'] }}</span>
                                                <span class="metric-value">{{ $card['value'] }}</span>
                                                <span class="metric-meta">{{ $card['meta'] }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>

                                <div class="insight-grid">
                                    @foreach ($insightCards as $card)
                                        @if (!empty($card['url']))
                                            <a href="{{ $card['url'] }}" class="insight-tile">
                                                <span class="insight-label">{{ $card['label'] }}</span>
                                                <div class="insight-title">{{ $card['title'] }}</div>
                                                <span class="insight-meta">{{ $card['meta'] }}</span>
                                            </a>
                                        @else
                                            <div class="insight-tile">
                                                <span class="insight-label">{{ $card['label'] }}</span>
                                                <div class="insight-title">{{ $card['title'] }}</div>
                                                <span class="insight-meta">{{ $card['meta'] }}</span>
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            @endif

                            <div class="row g-3">
                                @foreach (['left', 'right'] as $side)
                                    @php
                                        $chart = $section[$side]['chart'];
                                        $chartSubtitle =
                                            $chart['type'] === 'line'
                                                ? 'Trend across the selected range'
                                                : 'Ranked by volume';
                                    @endphp
                                    <div class="col-xl-6">
                                        <div class="report-card h-100">
                                            <div class="card-header pt-3 px-3">
                                                <div class="mb-1">{{ $chart['title'] }}</div>
                                            </div>
                                            <div class="card-body p-3">
                                                <div class="chart-wrap">
                                                    <canvas id="chart-{{ $key }}-{{ $side }}"></canvas>
                                                </div>
                                                <div class="mt-3">
                                                    @forelse($section[$side]['list'] as $item)
                                                        @if (!empty($item['url']))
                                                            <a href="{{ $item['url'] }}" class="rank-row">
                                                                <div class="w-100">
                                                                    <div class="d-flex justify-content-between gap-3 mb-2">
                                                                        <span>{{ $item['label'] }}</span>
                                                                        <strong>{{ $item['value'] }}</strong>
                                                                    </div>
                                                                    <div class="rank-bar"><span
                                                                            style="width: {{ min($item['percentage'], 100) }}%"></span>
                                                                    </div>
                                                                </div>
                                                            </a>
                                                        @else
                                                            <div class="rank-row">
                                                                <div class="w-100">
                                                                    <div class="d-flex justify-content-between gap-3 mb-2">
                                                                        <span>{{ $item['label'] }}</span>
                                                                        <strong>{{ $item['value'] }}</strong>
                                                                    </div>
                                                                    <div class="rank-bar"><span
                                                                            style="width: {{ min($item['percentage'], 100) }}%"></span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        @endif
                                                    @empty
                                                        <div>No data in this range.</div>
                                                    @endforelse
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            @if ($key === 'overview')
                                <div class="row g-3 mt-0">
                                    <div class="col-12">
                                        <div class="report-card h-100">
                                            <div class="card-header pt-3 px-3">
                                                <div class="mb-1">Operational Snapshot</div>
                                            </div>
                                            <div class="card-body px-3 pb-3 status-stack">
                                                @forelse($overviewStatus as $status)
                                                    @if (!empty($status['url']))
                                                        <a href="{{ $status['url'] }}" class="rank-row">
                                                            <span>{{ $status['label'] }}</span>
                                                            <span
                                                                class="badge bg-dark">{{ $status['value'] }}{{ $overviewStatusSuffix }}</span>
                                                        </a>
                                                    @else
                                                        <div class="rank-row">
                                                            <span>{{ $status['label'] }}</span>
                                                            <span
                                                                class="badge bg-dark">{{ $status['value'] }}{{ $overviewStatusSuffix }}</span>
                                                        </div>
                                                    @endif
                                                @empty
                                                    <div>No health indicators available in this range.</div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
