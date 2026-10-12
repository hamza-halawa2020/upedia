
    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="space-y-4">

                <x-page-title
                    title="Marketing Complaints"
                    description="Browse, filter, track, and manage client complaints across platforms, priorities, sales staff, and resolution status.">

                    @can('marketing_complains_create')
                        <a href="{{ route('complains.create') }}" class="asset-btn asset-btn--primary">
                            + Add Complain
                        </a>
                    @endcan

                </x-page-title>

                <div class="ui-card ui-card--table complain-filter-card">
                    <div class="ui-card__header">
                        <div class="complain-filter-header d-flex align-items-center gap-3 flex-wrap">
                            <h6 class="mb-0 font-semibold text-gray-800 whitespace-nowrap" style="margin-right:auto">
                                Filters
                            </h6>

                            <x-table-controls
                                :action="route('complains.index')"
                                :filters="$filters"
                                :date="true"
                            />
                        </div>
                    </div>
                </div>

                <div class="ui-card ui-card--table complain-table-card">

                    @if ($complains->isNotEmpty())
                        <x-table :headers="[
                            'ID',
                            'Platform',
                            'Client',
                            'Requester Name',
                            'Assigned Agent',
                            'Department',
                            'Case Type',
                            'Date',
                            'Priority',
                            'Inside/Outside',
                            'Status',
                            'Solved By',
                            'Created Date',
                            'Actions',
                        ]" :paginator="$complains">
                            @foreach ($complains as $complain)
@include('marketing::complaints.partials.index.table-row-1')
                            @endforeach

                        </x-table>
                    @else
                        <div class="empty-state-box">
                            <div class="empty-state-box__icon">
                                <iconify-icon icon="mdi:comment-alert-outline"></iconify-icon>
                            </div>

                            <div>
                                <div class="empty-state-box__title">No complaints found</div>
                                <div class="empty-state-box__text">
                                    There are no complaints matching the current filters.
                                </div>
                            </div>
                        </div>
                    @endif

                </div>

{{--                @if ($complains->hasPages())--}}
{{--                    <div class="pagination-shell">--}}
{{--                        {{ $complains->appends(request()->query())->links() }}--}}
{{--                    </div>--}}
{{--                @endif--}}

            </div>
        </div>
    </div>
