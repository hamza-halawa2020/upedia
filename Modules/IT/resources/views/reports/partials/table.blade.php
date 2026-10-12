<section>
    <h2 class="fs-5">{{ $title }}</h2>
    <div class="ui-table-wrap">
        <table class="ui-table">
            <thead>
                <tr>@foreach($columns as $label)
                <th>{{ $label }}</th>@endforeach
                </tr>
            </thead>
            <tbody>@forelse($rows as $row)
                <tr>
                    @foreach($columns as $key => $label)
                    <td>{{ data_get($row, $key) }}</td>@endforeach
            </tr>@empty<tr>
                    <td colspan="{{ count($columns) }}">No records found.</td>
                </tr>@endforelse
            </tbody>
        </table>
    </div>
</section>