                                @php
                                    $priorityClass = match ($complain->priority) {
                                        'high' => 'ui-pill--danger',
                                        'medium' => 'ui-pill--warn',
                                        'low' => 'ui-pill--success',
                                        default => 'ui-pill--neutral',
                                    };

                                    $statusClass = match ($complain->status) {
                                        'solved' => 'ui-pill--success',
                                        'not_solved' => 'ui-pill--danger',
                                        default => 'ui-pill--neutral',
                                    };

                                    $requesterName = trim(
                                        ($complain->staff?->first_name ?? '') . ' ' . ($complain->staff?->last_name ?? '')
                                    );

                                    $salesName = trim(
                                        ($complain->sales?->first_name ?? '') . ' ' . ($complain->sales?->last_name ?? '')
                                    );

                                    $departmentLabel = ucwords($complain->department ?? 'sales');
                                    $caseTypeLabel = ucwords(str_replace('_', ' ', $complain->case_type ?? 'complaint'));
                                @endphp

                                <tr id="complain-row-{{ $complain->id }}">
                                    <td class="ui-muted text-center">
                                        #{{ $complain->id }}
                                    </td>

                                    <td class="text-center">
                                        <span class="ui-pill ui-pill--info">
                                            {{ ucfirst($complain->platform) }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <div class="ui-title">
                                            {{ $complain->client_name ?: '-' }}
                                        </div>

                                        @if (!empty($complain->client_number))
                                            <small class="ui-muted d-block mt-1">
                                                {{ $complain->client_number }}
                                            </small>
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <div class="ui-title">
                                            {{ $requesterName ?: '-' }}
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <div class="ui-muted">
                                            {{ $salesName ?: '-' }}
                                        </div>
                                    </td>

                                    <td class="text-center">
                                        <span class="ui-pill ui-pill--neutral">
                                            {{ $departmentLabel }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <span class="ui-pill ui-pill--info">
                                            {{ $caseTypeLabel }}
                                        </span>
                                    </td>

                                    <td class="ui-muted text-center">
                                        {{ $complain->date ?: '-' }}
                                    </td>

                                    <td class="text-center">
                                        <span class="ui-pill {{ $priorityClass }}">
                                            {{ ucfirst($complain->priority) }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <span class="ui-pill ui-pill--neutral">
                                            {{ ucfirst($complain->inside_outside) }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        <span class="ui-pill {{ $statusClass }}">
                                            {{ ucwords(str_replace('_', ' ', $complain->status)) }}
                                        </span>
                                    </td>

                                    <td class="text-center">
                                        @if ($complain->status === 'solved' && $complain->solver)
                                            <div class="ui-title">
                                                {{ $complain->solver->full_name }}
                                            </div>
                                        @else
                                            <span class="ui-muted">---</span>
                                        @endif
                                    </td>

                                    <td class="ui-muted text-center">
                                        {{ $complain->created_at ? $complain->created_at->format('Y-m-d') : '-' }}
                                    </td>

                                    <td class="text-center" onclick="event.stopPropagation()">
                                        <div class="complain-actions">
                                            <div class="ui-actions justify-content-center">
@can('marketing_complains_show')
                                                    <x-table-action type="view" :url="route('complains.show', $complain->id)" />
@endcan

@can('marketing_complains_edit')
                                                    <x-table-action type="edit" :url="route('complains.edit', $complain->id)" />
@endcan

                                                @can('marketing_complains_destroy')
                                                    <button
                                                        type="button"
                                                        class="delete-action-btn"
                                                        data-bs-toggle="modal"
                                                        data-bs-target="#deleteModal_{{ $complain->id }}"
                                                        title="Delete Complain">
                                                        <span class="table-action table-action--danger">
                                                            <iconify-icon icon="fluent:delete-24-regular"></iconify-icon>
                                                        </span>
                                                    </button>
                                                @endcan
                                            </div>

                                            @can('crm_leads-create')
                                                @if (!$complain->lead_exists)
                                                    <a
                                                        href="{{ rtrim(config('app.CRM_URL'), '/') . '/leads/create?phone=' . urlencode($complain->client_number) . '&name=' . urlencode($complain->client_name) }}"
                                                        class="asset-btn asset-btn--secondary complain-lead-btn">
                                                        Convert To Lead
                                                    </a>
                                                @endif
                                            @endcan
                                        </div>

                                        @can('marketing_complains_destroy')
                                            <div class="modal fade" id="deleteModal_{{ $complain->id }}" tabindex="-1" aria-hidden="true">
                                                <div class="modal-dialog modal-dialog-centered">
                                                    <form action="{{ route('complains.destroy', $complain->id) }}" method="POST">
                                                        @csrf
                                                        @method('DELETE')

                                                        <div class="modal-content border-0 shadow-lg rounded-4">
                                                            <div class="modal-header border-bottom-0 pb-0">
                                                                <h5 class="modal-title">Delete Complain</h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                                            </div>

                                                            <div class="modal-body pt-3 text-start">
                                                                <p class="mb-0">
                                                                    Are you sure you want to delete complain
                                                                    <strong>#{{ $complain->id }}</strong>
                                                                    for
                                                                    <strong>{{ $complain->client_name }}</strong>?
                                                                </p>
                                                            </div>

                                                            <div class="modal-footer border-top-0 pt-0">
                                                                <button type="button" class="asset-btn asset-btn--secondary" data-bs-dismiss="modal">
                                                                    Cancel
                                                                </button>

                                                                <button type="submit" class="btn btn-outline-danger">
                                                                    Yes, Delete
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>
                                        @endcan
                                    </td>
                                </tr>
