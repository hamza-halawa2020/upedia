@extends('layout.layout')

@php
    $title = 'Roles';
    $subTitle = 'Create Role';
@endphp

@section('content')
    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="d-flex flex-column gap-4">
                <x-page-title
                    title="Create Role"
                    description="Create a new role and assign the permissions it should receive."
                >
                    <button type="button" class="asset-btn asset-btn--primary" id="globalSelectAllBtn">
                        Select All
                    </button>
                    <button type="button" class="asset-btn asset-btn--secondary" id="globalUnselectAllBtn">
                        Unselect All
                    </button>
                </x-page-title>

                <div class="ui-card border shadow-sm bg-white">
                    <div class="card-body p-3 p-lg-5">
                        <form action="{{ route('roles.store') }}" method="POST">
                            @csrf
                            <input type="hidden" name="is_editable" value="1">

                            <div class="ui-field-box mb-3">
                                <label for="name" class="form-label fw-semibold">Role Name</label>
                                <input type="text" name="name" id="name" value="{{ old('name') }}"
                                    class="form-control" required>
                                @error('name')
                                    <div class="text-danger mt-2">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="mb-3">
                                <h6 class="mb-3">Assign Permissions</h6>
                                <div class="accordion" id="permissionsAccordion">
                                    @php
                                        $groupedPermissions = [];
                                        $prefixes = ['general_', 'hr_', 'academy_', 'crm_', 'retention_', 'finance_', 'exam_', 'it_', 'marketing_'];

                                        foreach ($permissions as $permission) {
                                            $prefix = 'other';

                                            foreach ($prefixes as $itemPrefix) {
                                                if (str_starts_with($permission->name, $itemPrefix)) {
                                                    $prefix = $itemPrefix;
                                                    break;
                                                }
                                            }

                                            $groupedPermissions[$prefix][] = $permission;
                                        }
                                    @endphp

                                    @foreach ($groupedPermissions as $prefix => $permissionGroup)
                                        <div class="accordion-item border rounded-4 mb-3 overflow-hidden">
                                            <h2 class="accordion-header d-flex align-items-center gap-2 px-3 py-3"
                                                id="heading_{{ $prefix }}">
                                                <button class="accordion-button {{ $loop->first ? '' : 'collapsed' }} shadow-none"
                                                    type="button" data-bs-toggle="collapse"
                                                    data-bs-target="#collapse_{{ $prefix }}"
                                                    aria-expanded="{{ $loop->first ? 'true' : 'false' }}"
                                                    aria-controls="collapse_{{ $prefix }}">
                                                    {{ ucfirst(str_replace('_', ' ', trim($prefix, '_'))) }} Permissions
                                                </button>
                                                <button type="button"
                                                    class="btn btn-outline-primary btn-sm rounded-pill select-section"
                                                    data-section="{{ $prefix }}">
                                                    All
                                                </button>
                                                <button type="button"
                                                    class="btn btn-outline-secondary btn-sm rounded-pill unselect-section"
                                                    data-section="{{ $prefix }}">
                                                    None
                                                </button>
                                            </h2>
                                            <div id="collapse_{{ $prefix }}"
                                                class="accordion-collapse collapse {{ $loop->first ? 'show' : '' }}"
                                                aria-labelledby="heading_{{ $prefix }}"
                                                data-bs-parent="#permissionsAccordion">
                                                <div class="accordion-body">
                                                    <div class="row g-3">
                                                        @foreach ($permissionGroup as $permission)
                                                            <div class="col-md-4 col-sm-6">
                                                                <div class="form-check d-flex align-items-start gap-2">
                                                                    <input class="form-check-input permission-checkbox mt-1"
                                                                        type="checkbox" name="permissions[]"
                                                                        value="{{ $permission->id }}"
                                                                        id="permission_{{ $permission->id }}"
                                                                        data-section="{{ $prefix }}"
                                                                        {{ old('permissions') && in_array($permission->id, old('permissions', [])) ? 'checked' : '' }}>
                                                                    <label class="form-check-label"
                                                                        for="permission_{{ $permission->id }}"
                                                                        title="{{ ucfirst(str_replace('_', ' ', $permission->name)) }}"
                                                                        data-bs-toggle="tooltip" data-bs-placement="top">
                                                                        {{ ucfirst(str_replace('_', ' ', $permission->name)) }}
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endforeach
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <button type="submit" class="btn btn-outline-primary px-3">
                                Create Role
                            </button>
                            <a href="{{ route('roles.index') }}" class="btn btn-outline-secondary px-3">
                                Cancel
                            </a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();

            $('#globalSelectAllBtn').click(function() {
                $('.permission-checkbox').prop('checked', true);
            });

            $('#globalUnselectAllBtn').click(function() {
                $('.permission-checkbox').prop('checked', false);
            });

            $('.select-section').click(function() {
                const section = $(this).data('section');
                $(`.permission-checkbox[data-section="${section}"]`).prop('checked', true);
            });

            $('.unselect-section').click(function() {
                const section = $(this).data('section');
                $(`.permission-checkbox[data-section="${section}"]`).prop('checked', false);
            });
        });
    </script>
@endpush
