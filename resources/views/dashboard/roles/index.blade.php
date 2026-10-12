@extends('layout.layout')

@php
    $title = 'Roles';
    $subTitle = 'Role Management';
    $canManageSuperAdminRole = auth()->check() && auth()->user()->hasRole('Super admin');
@endphp

@section('content')
    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="d-flex flex-column gap-4">
                <x-page-title
                    title="Roles"
                    description="Manage platform roles and review how many permissions each role contains."
                >
                    <a href="{{ route('roles.create') }}" class="asset-btn asset-btn--primary">
                        + Create Role
                    </a>
                </x-page-title>

                <div class="ui-card border shadow-sm bg-white">
                    <div class="ui-card__header">
                        <div class="d-flex align-items-center gap-3 flex-nowrap">
                            <h6 class="mb-0 ui-title" style="margin-right: auto;">Filters</h6>
                            <x-table-controls :action="route('roles.index')" searchPlaceholder="Search roles..." />
                        </div>
                    </div>

                    <x-table
                        :headers="['#', 'Role', 'Permissions', 'Actions']"
                        :paginator="$roles"
                        emptyMessage="No roles found."
                    >
                        @foreach ($roles as $index => $role)
                            @continue($role->name === 'Super admin' && ! $canManageSuperAdminRole)

                            <tr>
                                <td class="text-center">{{ $roles->firstItem() + $index }}</td>
                                <td class="ui-title text-center">
                                    {{ $role->name }}
                                    @if ($role->name === 'Super admin')
                                        <div class="mt-2">
                                            <span class="ui-pill ui-pill--info">Protected</span>
                                        </div>
                                    @endif
                                </td>
                                <td class="text-center">
                                    <span class="ui-pill ui-pill--neutral">
                                        {{ $role->permissions_count }} Permissions
                                    </span>
                                </td>
                                <td class="text-center" onclick="event.stopPropagation()">
                                    <div class="ui-actions justify-content-center">
                                        <x-table-action type="edit" :url="route('roles.edit', $role->id)" />

                                        @if ($role->name !== 'Super admin' && $role->is_editable)
                                            <x-table-action type="delete" :target="'#deleteModal-' . $role->id" />
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </x-table>
                </div>

                @foreach ($roles as $role)
                    @if ($role->name !== 'Super admin' && $role->is_editable)
                        <div class="modal fade" id="deleteModal-{{ $role->id }}" tabindex="-1"
                            aria-labelledby="deleteModalLabel-{{ $role->id }}" aria-hidden="true">
                            <div class="modal-dialog">
                                <form method="POST" action="{{ route('roles.destroy', $role->id) }}">
                                    @csrf
                                    @method('DELETE')
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h6 class="modal-title" id="deleteModalLabel-{{ $role->id }}">
                                                Delete Role
                                            </h6>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            Are you sure you want to delete <strong>{{ $role->name }}</strong>?
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-outline-secondary"
                                                data-bs-dismiss="modal">
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
                    @endif
                @endforeach
            </div>
        </div>
    </div>
@endsection
