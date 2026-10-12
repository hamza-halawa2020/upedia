@extends('layout.layout')

@php
    $title = 'Departments';
    $subTitle = 'Department Tabs';
@endphp

@section('content')
    @include('components.alert')

    <div class="container-fluid app-bg">
        <div class="page-shell">
            <div class="d-flex flex-column gap-4">
                <x-page-title
                    title="Departments"
                    description="Browse departments and open each one to manage the tabs assigned to it."
                />

                <div class="ui-card border shadow-sm bg-white">
                    <div class="ui-card__header">
                        <div class="d-flex align-items-center gap-3 flex-nowrap">
                            <h6 class="mb-0 ui-title" style="margin-right: auto;">Filters</h6>
                            <x-table-controls :action="route('departments.index')" searchPlaceholder="Search departments..." />
                        </div>
                    </div>

                    <x-table
                        :headers="['ID', 'Name', 'Actions']"
                        :paginator="$departments"
                        emptyMessage="No departments found."
                    >
                        @foreach ($departments as $department)
                            <tr>
                                <td class="text-center">{{ $department->id }}</td>
                                <td class="ui-title text-center">{{ $department->name }}</td>
                                <td class="text-center" onclick="event.stopPropagation()">
                                    <div class="ui-actions justify-content-center">
                                        <x-table-action type="edit" :url="route('departments.edit', $department->id)" />
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
