@props([
    'headers' => [],
    'paginator' => null,
    'emptyMessage' => 'No data found.',
    'emptyActionText' => null,
    'emptyActionUrl' => null,
])

<div class="p-0">
    @if ($paginator && $paginator->count())
        <div class="ui-table-wrap nice-scrollbar">
            <table class="ui-table">
                <thead class="ui-table__head">
                    <tr>
                        @foreach ($headers as $header)
                            <th class="text-center">{{ $header }}</th>
                        @endforeach
                    </tr>
                </thead>

                <tbody class="ui-table__body">
                    {{ $slot }}
                </tbody>
            </table>
        </div>

        @if(method_exists($paginator, 'links'))
            <div class="px-3 py-3 border-t border-slate-200">
                {{ $paginator->links() }}
            </div>
        @endif
    @else
        <div class="px-6 py-12 text-center">
            <p class="text-slate-500 mb-3">{{ $emptyMessage }}</p>

            @if($emptyActionText && $emptyActionUrl)
                <a href="{{ $emptyActionUrl }}" class="ui-pill ui-pill--info" style="text-decoration:none">
                    {{ $emptyActionText }}
                </a>
            @endif
        </div>
    @endif
</div>




{{-- How to use it --}}

{{--  

<x-ui.table
    :headers="['Name', 'Product', 'Serial Number', 'Vendor', 'Department', 'Cost', 'Acquired On', 'Status', 'Actions']"
    :paginator="$assets"
    emptyMessage="No assets found matching the criteria."
    emptyActionText="+ Add First Asset"
    :emptyActionUrl="route('asset.create')"
>
    @foreach ($assets as $asset)
        <tr class="ui-row-click" onclick="window.location='{{ route('asset.show', $asset->id) }}'">
            <td class="ui-title text-center">{{ $asset->name }}</td>
            <td class="ui-muted text-center">
                <span class="ui-pill ui-pill--info">
                    {{ $asset->product?->name ?? '—' }}
                </span>
            </td>
            <td class="ui-muted text-center">{{ $asset->serial_number }}</td>
            <td class="ui-muted text-center">
                @if ($asset->vendor)
                    <a href="{{ route('vendors.index', ['search' => $asset->vendor->name]) }}"
                       class="ui-pill ui-pill--neutral text-center"
                       style="text-decoration:none">
                        {{ $asset->vendor->name }}
                    </a>
                @else
                    <span class="ui-pill ui-pill--neutral text-center">—</span>
                @endif
            </td>
            <td class="ui-muted text-center">
                {{ $asset->department?->name ?? $asset->user?->staff?->department?->name ?? '__' }}
            </td>
            <td class="text-right ui-muted">
                ${{ number_format($asset->purchase_cost, 2) }}
            </td>
            <td class="text-center ui-muted">
                {{ \Carbon\Carbon::parse($asset->acquisition_date)->format('Y-m-d') }}
            </td>
            <td class="text-center">
                @php
                    $assetStatusKey = match ($asset->is_currently_in_use) {
                        'in_use' => 'success',
                        'in_store' => 'neutral',
                        'in_repair' => 'warn',
                        default => 'neutral',
                    };

                    $assetStatusLabel = match ($asset->is_currently_in_use) {
                        'in_use' => 'In Use',
                        'in_store' => 'In Store',
                        'in_repair' => 'In Repair',
                        default => '—',
                    };
                @endphp

                <span class="ui-pill ui-pill--{{ $assetStatusKey }}">
                    {{ $assetStatusLabel }}
                </span>
            </td>
            <td class="text-center" onclick="event.stopPropagation()">
                <div class="ui-actions">
                    <x-table-action type="view" :url="route('asset.show', $asset->id)" />
                    <x-table-action type="edit" :url="route('asset.edit', $asset->id)" />
                </div>
            </td>
        </tr>
    @endforeach
</x-ui.table>

--}}

