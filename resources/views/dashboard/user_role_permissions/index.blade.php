@extends('layout.layout')

@php
    $title = 'Access Control';
    $subTitle = 'User Roles';
@endphp

@section('content')
    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="d-flex flex-column gap-4">
                <x-page-title
                    title="User Role Permissions"
                    description="Review user access, assigned roles, and open each user to edit project permissions."
                />

                <div class="ui-card border shadow-sm bg-white">
                    <div class="ui-card__header">
                        <div class="d-flex align-items-center gap-3 flex-nowrap">
                            <h6 class="mb-0 ui-title" style="margin-right: auto;">Filters</h6>
                            <x-table-controls
                                :action="route('user-role-permissions.index')"
                                searchPlaceholder="Search users..."
                            />
                        </div>
                    </div>

                    <x-table
                        :headers="['Name', 'Email', 'Roles', 'Actions']"
                        :paginator="$users"
                        emptyMessage="No users found."
                    >
                        @foreach ($users as $user)
                            @if ($user->exists)
                                <tr>
                                    <td class="ui-title text-center">
                                        {{ $user->full_name ?? ($user->name ?? 'N/A') }}
                                    </td>
                                    <td class="ui-muted text-center">{{ $user->email ?? 'N/A' }}</td>
                                    <td class="text-center">
                                        <div class="d-flex flex-wrap justify-content-center gap-2">
                                            @forelse ($user->roles as $role)
                                                <span class="ui-pill ui-pill--info">{{ $role->name }}</span>
                                            @empty
                                                <span class="ui-pill ui-pill--danger">No roles</span>
                                            @endforelse
                                        </div>
                                    </td>
                                    <td class="text-center" onclick="event.stopPropagation()">
                                        <div class="ui-actions justify-content-center">
                                            <x-table-action
                                                type="edit"
                                                :url="route('user-role-permissions.edit', $user->id)"
                                            />
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                    </x-table>
                </div>
            </div>
        </div>
    </div>
@endsection
