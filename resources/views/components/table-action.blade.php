@props([
    'type', // view, edit, delete, create, excel, pdf, csv, search
    'url' => null,
    'target' => null,
    'class' => '',
    'title' => null,
    'label' => null,
    'disabled' => false,
    'buttonType' => 'button', // button, submit
    'icon' => true, // toggle icon visibility
    'customIcon' => null,
    'onclick' => null,
])

@php
    $icons = [
        'view' => 'lucide:eye',
        'edit' => 'lucide:edit',
        'delete' => 'fluent:delete-24-regular',
        'create' => 'ic:baseline-plus',
        'excel' => 'bi:file-earmark-spreadsheet',
        'pdf' => 'bi:filetype-pdf',
        'csv' => 'bi:filetype-csv',
        'search' => 'lucide:search',
    ];

    $defaultClasses = [
        'view' => 'btn-outline-info',
        'edit' => 'btn-outline-primary',
        'delete' => 'btn-outline-danger',
        'create' => 'btn-outline-primary',
        'excel' => 'btn-outline-success',
        'pdf' => 'btn-outline-danger',
        'csv' => 'btn-outline-secondary',
        'search' => 'btn-outline-primary',
    ];

    $iconName = $customIcon ?? ($icons[$type] ?? 'lucide:help-circle');
    $btnClass = $disabled ? 'btn-outline-secondary' : ($defaultClasses[$type] ?? 'btn-outline-secondary');
    $displayTitle = $title ?? ucfirst($type);
@endphp

@if ($url && !$disabled)
    <a href="{{ $url }}" 
       {{ $attributes->merge(['class' => "btn $btnClass btn-sm radius-8 $class"]) }}
       title="{{ $displayTitle }}"
       @if($onclick) onclick="{{ $onclick }}" @endif
       aria-label="{{ $displayTitle }}">
        @if($icon)
            <iconify-icon icon="{{ $iconName }}" class="text-lg"></iconify-icon>
        @endif
        @if($label || !$slot->isEmpty())
            <span class="{{ $icon ? 'ms-1' : '' }}">{{ $label ?? $slot }}</span>
        @endif
    </a>
@elseif ($target || $disabled || $url || $buttonType === 'submit' || $onclick)
    <button type="{{ $buttonType }}" 
            {{ $attributes->merge(['class' => "btn $btnClass btn-sm radius-8 $class"]) }}
            @if($target && !$disabled) data-bs-toggle="modal" data-bs-target="{{ $target }}" @endif
            @if($disabled) disabled style="cursor: not-allowed;" @endif
            @if($onclick) onclick="{{ $onclick }}" @endif
            title="{{ $displayTitle }}"
            aria-label="{{ $displayTitle }}">
        @if($icon)
            <iconify-icon icon="{{ $iconName }}" class="text-lg"></iconify-icon>
        @endif
        @if($label || !$slot->isEmpty())
            <span class="{{ $icon ? 'ms-1' : '' }}">{{ $label ?? $slot }}</span>
        @endif
    </button>
@endif
