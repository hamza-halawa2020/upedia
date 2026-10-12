<!DOCTYPE html>
<html lang="en">
<head><meta charset="utf-8"><title>{{ $title }}</title>
<style>
body { font-family: 'DejaVu Sans', sans-serif; font-size: 9px; }
h1 { font-size: 18px; }
table { width: 100%; border-collapse: collapse; table-layout: fixed; }
th, td { border: 1px solid #cccccc; padding: 5px; overflow-wrap: break-word; }
th { background: #eeeeee; text-align: left; }
thead { display: table-header-group; }
tr { page-break-inside: avoid; }
</style></head>
<body><h1>{{ $title }}</h1><table>
    <thead><tr>@foreach($headings as $heading)<th>{{ $heading }}</th>@endforeach</tr></thead>
    <tbody>@forelse($rows as $row)<tr>@foreach($row as $value)<td>{{ $value }}</td>@endforeach</tr>
        @empty<tr><td colspan="{{ count($headings) }}">No records found.</td></tr>@endforelse</tbody>
</table></body></html>
