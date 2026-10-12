@extends('layout.layout')

@php
    $title = 'Access Control';
    $subTitle = 'Edit User Access';
@endphp

@section('content')
    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="d-flex flex-column gap-4">
                <x-page-title
                    title="Edit User Access"
                    description="Assign roles and project access for {{ $user->full_name ?? ($user->name ?? 'this user') }}."
                >
                    <a href="{{ route('user-role-permissions.index') }}" class="asset-btn asset-btn--secondary">
                        Back to Users
                    </a>
                </x-page-title>

                @if ($user->exists)
                    <div class="ui-card border shadow-sm bg-white">
                        <div class="card-body p-3 p-lg-5">
                            <form action="{{ route('user-role-permissions.update', $user->id) }}" method="POST"
                                class="d-flex flex-column gap-4">
                                @csrf
                                @method('PUT')

                                <div class="ui-field-box">
                                    <label class="form-label fw-semibold">Roles</label>
                                    <div class="row g-3">
                                        @foreach ($roles as $role)
                                            <div class="col-md-4 col-sm-6">
                                                <div class="form-check d-flex align-items-center gap-2">
                                                    <input type="checkbox" name="roles[]" id="role-{{ $role->id }}"
                                                        value="{{ $role->id }}" class="form-check-input"
                                                        {{ $user->hasRole($role->name) ? 'checked' : '' }}
                                                        data-bs-toggle="tooltip" data-bs-placement="top"
                                                        title="Assign {{ $role->name }} role">
                                                    <label for="role-{{ $role->id }}" class="form-check-label">
                                                        {{ ucfirst($role->name) }}
                                                    </label>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                    @error('roles')
                                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="ui-field-box">
                                    <label for="access" class="form-label fw-semibold">Project Access</label>
                                    @php
                                        $access = json_decode($user->project_access, true) ?? [];
                                    @endphp

                                    <select multiple class="form-select general-select" id="access"
                                        name="project_access[]">
                                        <option value="hr" {{ in_array('hr', $access) ? 'selected' : '' }}>HR</option>
                                        <option value="crm" {{ in_array('crm', $access) ? 'selected' : '' }}>CRM</option>
                                        <option value="academy" {{ in_array('academy', $access) ? 'selected' : '' }}>
                                            Academy
                                        </option>
                                        <option value="settings" {{ in_array('settings', $access) ? 'selected' : '' }}>
                                            Settings
                                        </option>
                                    </select>
                                    @error('project_access')
                                        <small class="text-danger d-block mt-2">{{ $message }}</small>
                                    @enderror
                                </div>

                                <div class="d-flex flex-wrap gap-2">
                                    <button type="submit" class="btn btn-outline-primary px-3">
                                        Update Access
                                    </button>
                                    <a href="{{ route('user-role-permissions.index') }}"
                                        class="btn btn-outline-secondary px-3">
                                        Cancel
                                    </a>
                                </div>
                            </form>
                        </div>
                    </div>
                @else
                    <div class="alert alert-danger shadow-sm rounded-3" role="alert">
                        User not found.
                    </div>
                @endif
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('[data-bs-toggle="tooltip"]').tooltip();
        });
    </script>
@endpush
