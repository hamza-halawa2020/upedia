@extends('layout.layout')

@php
    $title = 'Permissions';
    $subTitle = 'Permission Management';
    $permissionsIndexRoute = Route::has('permissions.index') ? route('permissions.index') : null;
    $permissionsCreateRoute = Route::has('permissions.create') ? route('permissions.create') : null;
@endphp

@section('content')
    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="d-flex flex-column gap-4">
                <x-page-title
                    title="Permissions"
                    description="Review and maintain the permission list used across the settings workspace."
                >
                    @if ($permissionsCreateRoute)
                        <a href="{{ $permissionsCreateRoute }}" class="asset-btn asset-btn--primary">
                            + Create Permission
                        </a>
                    @endif
                </x-page-title>

                <div class="ui-card border shadow-sm bg-white">
                    <div class="ui-card__header">
                        <div class="d-flex align-items-center gap-3 flex-nowrap">
                            <h6 class="mb-0 ui-title" style="margin-right: auto;">Permission List</h6>

                            @if ($permissionsIndexRoute)
                                <x-table-controls :action="$permissionsIndexRoute" searchPlaceholder="Search permissions..." />
                            @endif
                        </div>
                    </div>

                    <x-table
                        :headers="['#', 'Permission', 'Actions']"
                        :paginator="$permissions"
                        emptyMessage="No permissions found."
                    >
                        @foreach ($permissions as $permission)
                            @php
                                $editRoute = Route::has('permissions.edit') ? route('permissions.edit', $permission->id) : null;
                                $destroyRoute = Route::has('permissions.destroy') ? route('permissions.destroy', $permission->id) : null;
                            @endphp

                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="ui-title text-center">{{ $permission->name }}</td>
                                <td class="text-center" onclick="event.stopPropagation()">
                                    <div class="ui-actions justify-content-center">
                                        @if ($editRoute)
                                            <x-table-action type="edit" :url="$editRoute" />
                                        @endif

                                        @if ($destroyRoute)
                                            <x-table-action
                                                type="delete"
                                                onclick="confirmPermissionDelete(event, '{{ $destroyRoute }}')"
                                            />
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </x-table>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        function confirmPermissionDelete(event, url) {
            event.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#6c757d',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if (!result.isConfirmed) {
                    return;
                }

                $('<form>', {
                    method: 'POST',
                    action: url
                }).append('@csrf').append('@method("DELETE")').appendTo('body').submit();
            });
        }
    </script>
@endpush
