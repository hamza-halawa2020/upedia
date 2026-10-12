
    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="space-y-4">

                <x-page-title title="Marketing Plans"
                    description="Browse, filter, export, and manage marketing plans by platform, status, type, and publish date.">

                    <a href="{{ route('plans.create') }}" class="asset-btn asset-btn--primary">
                        + Add New Plan
                    </a>

                </x-page-title>

                <div class="ui-card ui-card--table plans-filter-card">
                    <div class="ui-card__header">
                        <div class="d-flex align-items-center gap-3 flex-nowrap">
                            <h6 class="mb-0 font-semibold text-gray-800 whitespace-nowrap" style="margin-right:auto">
                                Filters
                            </h6>

                            <x-table-controls :action="route('plans.index')" :filters="$filters" :date="true" :export="true"
                                :exportRoute="route('plans.export')" />
                        </div>
                    </div>
                </div>

                <div class="ui-card ui-card--table plans-table-card">

                    @if ($plans->isNotEmpty())
                                <x-table :headers="[
                            'ID',
                            'Name',
                            'Platform',
                            'Subject',
                            'Created By',
                            'Published Date',
                            'Status',
                            'Actions',
                        ]" :paginator="$plans">

                            @foreach ($plans as $plan)
                                @php
                                    $statusClass = match ($plan->status) {
                                        'draft' => 'ui-pill--neutral',
                                        'under-review' => 'ui-pill--info',
                                        'ready-to-publish' => 'ui-pill--primary',
                                        'not-approved' => 'ui-pill--danger',
                                        'published' => 'ui-pill--success',
                                        default => 'ui-pill--neutral',
                                    };

                                    $creatorName = trim(
                                        ($plan->staff?->first_name ?? '') . ' ' . ($plan->staff?->last_name ?? '')
                                    );
                                @endphp

                                <tr id="plan-row-{{ $plan->id }}">
                                    <td class="ui-muted text-center">
                                        #{{ $plan->id }}
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('plans.show', $plan->id) }}" class="ui-title text-decoration-none">
                                            {{ $plan->name ?: '-' }}
                                        </a>
                                    </td>

                                    <td class="text-center">
                                        <span class="ui-pill ui-pill--info">
                                            {{ ucfirst($plan->platform) }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="ui-title">
                                            {{ $plan->subject ? ucfirst($plan->subject) : '-' }}
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="ui-muted">
                                            {{ $creatorName ?: '-' }}
                                        </div>
                                    </td>

                                    <td class="ui-muted text-center">
                                        {{ $plan->publish_date ?: '-' }}
                                    </td>

                                    <td class="text-center">
                                        <span class="ui-pill {{ $statusClass }}">
                                            {{ ucfirst(str_replace('-', ' ', $plan->status)) }}
                                        </span>
                                    </td>

                                    <td class="text-center" onclick="event.stopPropagation()">
                                        <div class="ui-actions justify-content-center">
                                            @can('marketing_plans_show')
                                                <x-table-action type="view" :url="route('plans.show', $plan->id)" />
                                            @endcan

                                            @can('marketing_plans_edit')
                                                <x-table-action type="edit" :url="route('plans.edit', $plan->id)" />
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </x-table>
                    @else
                        <div class="empty-state-box">
                            <div class="empty-state-box__icon">
                                <iconify-icon icon="mdi:calendar-text-outline"></iconify-icon>
                            </div>

                            <div>
                                <div class="empty-state-box__title">No marketing plans found</div>
                                <div class="empty-state-box__text">
                                    No plans match the selected filters. You can create the first plan now.
                                </div>

                                <a href="{{ route('plans.create') }}" class="asset-btn asset-btn--primary mt-3">
                                    + Add First Plan
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
