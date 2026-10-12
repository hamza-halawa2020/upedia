    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="space-y-4">

                <x-page-title
                    title="Marketing Plan Calendar"
                    description="View marketing plans by publish date, platform, status, creator, and content type in a monthly, weekly, or daily calendar view.">
                </x-page-title>

                {{-- Filters --}}
                <div class="ui-card calendar-filter-card">
                    <div class="form-section">
                        <div class="form-section__head">
                            <h5 class="form-section__title mb-1">Calendar Filters</h5>
                            <p class="form-section__sub mb-0">
                                Filter plans by status or platform. The calendar will update automatically.
                            </p>
                        </div>

                        <div class="calendar-filter-grid">

                            <div class="calendar-filter-group">
                                <div class="calendar-filter-title">
                                    Filter by Status
                                </div>

                                <div class="filter-checkboxes" id="status-filters">
