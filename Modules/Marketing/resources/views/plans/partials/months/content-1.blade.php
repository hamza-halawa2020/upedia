    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="space-y-4">

                <x-page-title
                    title="Marketing Plans"
                    description="Choose a month to browse and manage marketing plans, campaigns, publishing schedule, and content workflow.">

                    <a href="{{ route('plans.create') }}" class="asset-btn asset-btn--primary">
                        + Add New Plan
                    </a>

                </x-page-title>

                <div class="ui-card">
                    <div class="form-section">

                        <div class="form-section__head">
                            <h5 class="form-section__title mb-1">Select Month</h5>
                            <p class="form-section__sub mb-0">
                                Pick a month to view all marketing plans scheduled for that period.
                            </p>
                        </div>

                        <div class="months-grid">
                            @foreach ($months as $month)
                                @php
                                    $monthName = is_numeric($month)
                                        ? \Carbon\Carbon::create()->month($month)->format('F')
                                        : $month;

                                    $monthUrl = route('plans.index', ['month' => $monthName]);

                                    $isActiveMonth = request('month') === $monthName;
                                @endphp

                                <a href="{{ $monthUrl }}"
                                   class="month-card {{ $isActiveMonth ? 'month-card--active' : '' }}">

                                    <div class="month-card__icon">
                                        <i class="fas fa-calendar-alt"></i>
                                    </div>

                                    <div class="month-card__content">
                                        <div class="month-card__title">
                                            {{ $monthName }}
                                        </div>

                                        <div class="month-card__sub">
                                            View plans
                                        </div>
                                    </div>

                                    <div class="month-card__arrow">
                                        <iconify-icon icon="lucide:arrow-right"></iconify-icon>
                                    </div>

                                </a>
                            @endforeach
                        </div>

                    </div>
                </div>

            </div>
        </div>
    </div>
