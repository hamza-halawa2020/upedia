@props([
    'action',
    'filters' => [],
    'export' => false,
    'date' => false,
    'exportRoute' => null,
    'searchName' => 'search',
    'searchPlaceholder' => 'search',
    'startDateName' => 'start_date',
    'endDateName' => 'end_date',
    'formId' => 'table-controls-form',
    'filterLabels' => []
])
<form action="{{ $action }}" method="GET" id="{{ $formId }}" class="d-inline-flex align-items-center gap-3 flex-nowrap mb-0">
    {{ $slot }}
    {{-- Per Page --}}
    <select name="per_page" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
        @foreach ([5, 10, 25, 50, 100, 150] as $count)
            <option value="{{ $count }}" {{ request('per_page', 10) == $count ? 'selected' : '' }}>
                {{ $count }}
            </option>
        @endforeach
    </select>

    {{-- Custom Filters --}}
    @foreach ($filters as $name => $options)
        <select name="{{ $name }}" class="form-select form-select-sm w-auto" onchange="this.form.submit()">
            <option value="">{{ $filterLabels[$name] ?? ucfirst(str_replace('_', ' ', $name)) }}</option>
            @foreach ($options as $value => $label)
                <option value="{{ $value }}" {{ request($name) == $value ? 'selected' : '' }}>
                    {{ $label }}
                </option>
            @endforeach
        </select>
    @endforeach

    {{-- Search --}}
    <div class="input-group input-group-sm w-auto">
        <input type="text" class="form-control" name="{{ $searchName }}" placeholder="{{ $searchPlaceholder }}"
            value="{{ request($searchName) }}">
        <button class="btn btn-outline-secondary" type="submit">
            <iconify-icon icon="ion:search-outline"></iconify-icon>
        </button>
    </div>

    {{-- Date Range --}}
    @if(isset($date) && $date === true)
        <div class="d-flex gap-2 align-items-center">
            <input type="date" name="{{ $startDateName }}" class="form-control form-control-sm" value="{{ request($startDateName) }}" onchange="this.form.submit()">
            <input type="date" name="{{ $endDateName }}" class="form-control form-control-sm" value="{{ request($endDateName) }}" onchange="this.form.submit()">
        </div>
    @endif

    {{-- Export --}}
    @if(isset($export) && $export === true)
        <div class="input-group input-group-sm w-auto">
            <select name="format" id="export-format-{{ $formId }}" class="form-select form-select-sm">
                <option value="" disabled selected>Export</option>
                <option value="xlsx">Excel</option>
                <option value="csv">CSV</option>
                <option value="pdf">PDF</option>
            </select>
            <button class="btn btn-outline-success btn-sm" type="button" onclick="handleExport_{{ str_replace('-', '_', $formId) }}()">
                <iconify-icon icon="mdi:download"></iconify-icon>
            </button>
        </div>
        <script>
            function handleExport_{{ str_replace('-', '_', $formId) }}() {
                const format = document.getElementById('export-format-{{ $formId }}').value;
                if (!format) {
                    alert('Please select an export format');
                    return;
                }
                const form = document.getElementById('{{ $formId }}');
                const originalAction = form.action;
                const exportRoute = "{{ $exportRoute }}";
                
                // Temporarily change form action for export
                form.action = exportRoute;
                form.submit();
                
                // Restore original action after a short delay
                setTimeout(() => {
                    form.action = originalAction;
                }, 100);
            }
        </script>
    @endif

    {{-- Clear Filters --}}
    <a href="{{ $action }}" class="btn btn-outline-danger btn-sm">
        Clear
    </a>
</form>
