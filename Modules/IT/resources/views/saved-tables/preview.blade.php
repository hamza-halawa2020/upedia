@extends('layout.layout')
@section('content')
    <div class="app-bg">
        <div class="page-shell space-y-4">
            <x-page-title :title="$table->table_name">
                <a href="{{ route('it.filtered_tables.download', $table->id) }}" class="btn btn-outline-primary"
                    title="Download complete file"><iconify-icon icon="lucide:download"></iconify-icon></a>
            </x-page-title>
            <div class="ui-table-wrap nice-scrollbar">
                <table class="ui-table">
                    <thead>
                        <tr>@foreach($headers as $header)
                        <th>{{ $header }}</th>@endforeach
                        </tr>
                    </thead>
                    <tbody>@forelse($rows as $row)
                        <tr>@foreach($row as $value)
                        <td>{{ $value }}</td>@endforeach
                        </tr>
                    @empty<tr>
                            <td colspan="{{ max(count($headers), 1) }}">No rows found.</td>
                        </tr>@endforelse
                    </tbody>
                </table>
            </div>
            <a href="{{ route('it.filtered_tables.index') }}">Back</a>
        </div>
    </div>
@endsection