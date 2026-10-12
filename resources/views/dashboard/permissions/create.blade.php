@extends('layout.layout')

@php
    $title = 'Permissions';
    $subTitle = 'Create Permission';
    $permissionsStoreRoute = Route::has('permissions.store') ? route('permissions.store') : '#';
    $permissionsIndexRoute = Route::has('permissions.index') ? route('permissions.index') : null;
@endphp

@section('content')
    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="d-flex flex-column gap-4">
                <x-page-title title="Create Permission" description="Add a new permission key to the settings project.">
                    @if ($permissionsIndexRoute)
                        <a href="{{ $permissionsIndexRoute }}" class="asset-btn asset-btn--secondary">
                            Back to Permissions
                        </a>
                    @endif
                </x-page-title>

                <div class="ui-card border shadow-sm bg-white">
                    <div class="card-body p-3 p-lg-5">
                        <form action="{{ $permissionsStoreRoute }}" method="POST" class="d-flex flex-column gap-4">
                            @csrf

                            <div class="ui-field-box">
                                <label for="name" class="form-label fw-semibold">Permission Name</label>
                                <input type="text" name="name" id="name" class="form-control"
                                    placeholder="Enter permission name">
                            </div>

                            <button type="submit" class="btn btn-outline-primary px-3">
                                Save Permission
                            </button>

                            @if ($permissionsIndexRoute)
                                <a href="{{ $permissionsIndexRoute }}" class="btn btn-outline-secondary px-3">
                                    Cancel
                                </a>
                            @endif
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection