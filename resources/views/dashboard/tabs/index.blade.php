@extends('layout.layout')

@php
    $title = 'Tabs';
    $subTitle = 'Navigation';

    $parentFilterOptions = $parentTabs->mapWithKeys(fn($parent) => [$parent->id => $parent->label])->toArray();
    $systemFilterOptions = $allSystems->mapWithKeys(fn($system) => [$system => strtoupper($system)])->toArray();
    $typeFilterOptions = [
        'link' => 'Link (With URL)',
        'group' => 'Group (No URL)',
    ];
@endphp

@section('content')
    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="d-flex flex-column gap-4">
                <x-page-title
                    title="Tabs"
                    description="Manage navigation tabs, systems visibility, hierarchy, and display order from one place."
                >
                        <button type="button" class="asset-btn asset-btn--primary" data-bs-toggle="modal"
                            data-bs-target="#createModal">
                            + Add Parent Tab
                        </button>

                        {{-- <button type="button" class="asset-btn asset-btn--secondary" data-bs-toggle="modal"
                            data-bs-target="#importModal">
                            Import CSV
                        </button> --}}

                        <a href="{{ route('tabs.export', request()->query()) }}" class="asset-btn asset-btn--secondary">
                            Export CSV
                        </a>
                </x-page-title>

                <div class="ui-card border shadow-sm bg-white">
                    <div class="ui-card__header">
                        <div class="d-flex align-items-center gap-3 flex-wrap">
                            <h6 class="mb-0 ui-title" style="margin-right: auto;">Filters</h6>

                            <x-table-controls
                                :action="route('tabs.index')"
                                :filters="[
                                    'parent_id' => $parentFilterOptions,
                                    'system' => $systemFilterOptions,
                                    'type' => $typeFilterOptions,
                                ]"
                                :filterLabels="[
                                    'parent_id' => 'All Parents',
                                    'system' => 'All Systems',
                                    'type' => 'All Types',
                                ]"
                                searchPlaceholder="Search label..."
                            />
                        </div>
                    </div>

                    <x-table
                        :headers="['ID', 'Label', 'Icon', 'Parent', 'Systems', 'Order', 'Actions']"
                        :paginator="$tabs"
                        emptyMessage="No tabs found."
                    >
                        @foreach ($tabs as $tab)
                            <tr>
                                <td class="text-center">{{ $tab->id }}</td>
                                <td class="ui-title text-center">
                                    @if ($tab->url)
                                        <a href="{{ $tab->url }}" target="_blank" rel="noopener noreferrer">
                                            {{ $tab->label }}
                                        </a>
                                    @else
                                        {{ $tab->label }}
                                    @endif
                                </td>
                                <td class="text-center">
                                    <iconify-icon icon="{{ $tab->icon }}" width="24"></iconify-icon>
                                </td>
                                <td class="text-center">{{ $tab->parent->label ?? '—' }}</td>
                                <td class="text-center">
                                    <div class="d-flex flex-wrap justify-content-center gap-2">
                                        @forelse ($tab->systems ?? [] as $system)
                                            <span class="ui-pill ui-pill--info">{{ strtoupper($system) }}</span>
                                        @empty
                                            <span class="ui-pill ui-pill--neutral">No systems</span>
                                        @endforelse
                                    </div>
                                </td>
                                <td class="text-center">{{ $tab->order }}</td>
                                <td class="text-center" onclick="event.stopPropagation()">
                                    <div class="ui-actions justify-content-center">
                                        <x-table-action type="edit" :target="'#editModal' . $tab->id" />
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </x-table>
                </div>
            </div>

            <div class="modal fade" id="importModal" tabindex="-1" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('tabs.import') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <div class="modal-header">
                                <h5 class="modal-title">Import Tabs from CSV</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Close"></button>
                            </div>

                            <div class="modal-body">
                                <div class="mb-3">
                                    <label for="file" class="form-label">Choose CSV File</label>
                                    <input type="file" class="form-control" name="file" accept=".csv,.txt" required>
                                    <div class="form-text mt-2">
                                        Make sure your file follows the required format.
                                        <a href="{{ route('tabs.template') }}">Download template here.</a>
                                    </div>
                                </div>

                                <div class="alert alert-info py-2 small mb-0">
                                    <p class="mb-1"><strong>Column Guidelines:</strong></p>
                                    <ul class="mb-0 ps-3">
                                        <li><strong>label</strong>: Required.</li>
                                        <li><strong>url</strong>: Optional link destination.</li>
                                        <li><strong>parent_label</strong>: Optional group name.</li>
                                        <li><strong>systems</strong>: Comma-separated list such as <code>hr,crm</code>.</li>
                                    </ul>
                                </div>
                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">
                                    Close
                                </button>
                                <button type="submit" class="btn btn-outline-primary">
                                    Import
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

            @include('dashboard.tabs.create')

            @foreach ($tabs as $tab)
                @include('dashboard.tabs.edit', ['tab' => $tab, 'tabs' => $tabs])
            @endforeach
        </div>
    </div>
@endsection

@push('styles')
    <style>
        .icon-option {
            cursor: pointer;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 6px;
            transition: all 0.2s ease-in-out;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 48px;
            height: 48px;
        }

        .icon-option:hover {
            background: #f0f0f0;
            transform: scale(1.05);
        }

        .icon-option.active {
            border-color: #007bff;
            background: #e7f1ff;
            box-shadow: 0 0 0 2px rgba(0, 123, 255, 0.25);
        }

        .icon-grid {
            max-height: 200px;
            overflow-y: auto;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 10px;
        }
    </style>
@endpush

@push('scripts')
    <script>
        if (typeof window.tabIconsLoaded === 'undefined') {
            window.tabIconsLoaded = true;
            window.availableIcons = [];

            fetch("https://raw.githubusercontent.com/iconify/icon-sets/master/json/mdi.json")
                .then((response) => response.json())
                .then((data) => {
                    if (data.icons) {
                        window.availableIcons = Object.keys(data.icons).map((icon) => `mdi:${icon}`);
                    }
                })
                .catch((error) => console.error('Error loading icons:', error));

            function loadIcons(modalId, currentIcon = '') {
                const modal = document.getElementById(modalId);
                if (!modal) return;

                const grid = modal.querySelector('.icon-grid');
                if (!grid) return;

                grid.innerHTML = '';

                if (window.availableIcons.length === 0) {
                    grid.innerHTML = `
                        <div class="text-center w-100 p-3">
                            <div class="spinner-border spinner-border-sm" role="status"></div>
                            <div class="mt-2">Loading icons...</div>
                        </div>
                    `;
                    return;
                }

                window.availableIcons.slice(0, 8000).forEach((icon) => {
                    const item = document.createElement('div');
                    item.classList.add('icon-option');
                    item.dataset.icon = icon;
                    item.innerHTML = `<iconify-icon icon="${icon}" width="28" height="28"></iconify-icon>`;

                    if (icon === currentIcon) {
                        item.classList.add('active');
                    }

                    item.addEventListener('click', function() {
                        grid.querySelectorAll('.icon-option').forEach((option) => option.classList.remove('active'));
                        this.classList.add('active');
                        modal.querySelector('.selected-icon').value = this.dataset.icon;
                    });

                    grid.appendChild(item);
                });
            }

            document.addEventListener('shown.bs.modal', function(event) {
                const modal = event.target;
                const modalId = modal.getAttribute('id');

                if (modalId.startsWith('editModal') || modalId === 'createModal') {
                    const currentIcon = modal.querySelector('.selected-icon').value;
                    loadIcons(modalId, currentIcon);
                }
            });
        }
    </script>
@endpush
