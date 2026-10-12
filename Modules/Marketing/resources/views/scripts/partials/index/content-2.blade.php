
    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="space-y-4">

                <x-page-title title="Scripts"
                    description="Browse, filter, export, and manage marketing scripts by department, visibility, approval status, creator, and category.">

                    @can('marketing_scripts_create')
                        <a href="{{ route('scripts.create') }}" class="asset-btn asset-btn--primary">
                            + Add New Script
                        </a>
                    @endcan

                </x-page-title>

                <div class="ui-card ui-card--table scripts-filter-card">
                    <div class="ui-card__header">
                        <div class="d-flex align-items-center gap-3 flex-nowrap">
                            <h6 class="mb-0 font-semibold text-gray-800 whitespace-nowrap" style="margin-right:auto">
                                Filters
                            </h6>

                            <x-table-controls :action="route('scripts.index')" :filters="$filters" :export="true"
                                :exportRoute="route('script.export')" />
                        </div>
                    </div>
                </div>

                <div class="ui-card ui-card--table scripts-table-card">

                    @if ($scripts->isNotEmpty())
                                <x-table :headers="[
                            'ID',
                            'Title',
                            'Category',
                            'Status',
                            'Visibility',
                            'Created By',
                            'Created On',
                            'Action',
                        ]" :paginator="$scripts">

                            @foreach ($scripts as $scr)
                                @php
                                    $statusClass = match ($scr->status) {
                                        'approved' => 'ui-pill--success',
                                        'unapproved' => 'ui-pill--danger',
                                        default => 'ui-pill--neutral',
                                    };

                                    $visibilityClass = match ($scr->visibility) {
                                        'public' => 'ui-pill--success',
                                        'private' => 'ui-pill--neutral',
                                        default => 'ui-pill--neutral',
                                    };

                                    $statusIcon = match ($scr->status) {
                                        'approved' => 'fa-solid fa-circle-check',
                                        'unapproved' => 'fa-solid fa-circle-xmark',
                                        default => 'fa-solid fa-circle-question',
                                    };

                                    $visibilityIcon = match ($scr->visibility) {
                                        'public' => 'fa-globe',
                                        'private' => 'fa-lock',
                                        default => 'fa-question-circle',
                                    };
                                @endphp

                                <tr id="script-row-{{ $scr->id }}">
                                    <td class="ui-muted text-center">
                                        #{{ $scr->id }}
                                    </td>

                                    <td class="text-center">
                                        <a href="{{ route('scripts.show', $scr->id) }}" class="ui-title text-decoration-none">
                                            {{ $scr->title ?: '-' }}
                                        </a>
                                    </td>

                                    <td class="text-center">
                                        <span class="ui-pill ui-pill--info">
                                            {{ $scr->category_name ?: '-' }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center gap-1">
                                            <span class="ui-pill {{ $statusClass }}">
                                                <i class="{{ $statusIcon }} me-1"></i>
                                                {{ ucfirst($scr->status) }}
                                            </span>

                                            @if ($scr->status === 'approved' && $scr->approver)
                                                <small class="script-meta text-success">
                                                    <i class="fas fa-user-check me-1"></i>
                                                    {{ $scr->approver->full_name }}
                                                </small>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="d-flex flex-column align-items-center gap-2">
                                            <span class="ui-pill {{ $visibilityClass }}">
                                                <i class="fas {{ $visibilityIcon }} me-1"></i>
                                                {{ ucfirst($scr->visibility) }}
                                            </span>

                                            @if ($scr->departments && $scr->departments->count())
                                                <div class="script-departments">
                                                    @foreach ($scr->departments as $dept)
                                                        <span class="script-department-chip">
                                                            {{ $dept->name }}
                                                        </span>
                                                    @endforeach
                                                </div>
                                            @else
                                                <span class="ui-muted">No departments</span>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="ui-muted">
                                            {{ optional($scr->creator)->full_name ?? 'N/A' }}
                                        </div>
                                    </td>

                                    <td class="ui-muted text-center">
                                        {{ \Carbon\Carbon::parse($scr->created_at)->format('d M Y') }}
                                    </td>

                                    <td class="text-center" onclick="event.stopPropagation()">
                                        <div class="ui-actions justify-content-center">
                                            @can('marketing_scripts_show')
                                                <x-table-action type="view" :url="route('scripts.show', $scr->id)" />
                                            @endcan

                                            @can('marketing_scripts_edit')
                                                <x-table-action type="edit" :url="route('scripts.edit', $scr->id)" />
                                            @endcan
                                        </div>
                                    </td>
                                </tr>
                            @endforeach
                        </x-table>
                    @else
                        <div class="empty-state-box">
                            <div class="empty-state-box__icon">
                                <iconify-icon icon="mdi:script-text-outline"></iconify-icon>
                            </div>

                            <div>
                                <div class="empty-state-box__title">No scripts found</div>
                                <div class="empty-state-box__text">
                                    No scripts match the selected filters. You can create the first script now.
                                </div>

                                @can('marketing_scripts_create')
                                    <a href="{{ route('scripts.create') }}" class="asset-btn asset-btn--primary mt-3">
                                        + Add First Script
                                    </a>
                                @endcan
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
