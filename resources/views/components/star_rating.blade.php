@props(['rating', 'max' => 5])

@php
    $rating = floatval($rating);
    $fullStars = floor($rating);
    $hasHalfStar = ($rating - $fullStars) >= 0.5;
    $emptyStars = $max - $fullStars - ($hasHalfStar ? 1 : 0);
@endphp

<div class="d-flex">
    {{-- النجوم الكاملة --}}
    @for($i = 0; $i < $fullStars; $i++)
        <iconify-icon icon="mdi:star" class="text-warning" style="font-size: 1.2rem;"></iconify-icon>
    @endfor

    {{-- النجم النصفي --}}
    @if($hasHalfStar)
        <iconify-icon icon="mdi:star-half-full" class="text-warning" style="font-size: 1.2rem;"></iconify-icon>
    @endif

    {{-- النجوم الفارغة --}}
    @for($i = 0; $i < $emptyStars; $i++)
        <iconify-icon icon="mdi:star-outline" class="text-warning" style="font-size: 1.2rem;"></iconify-icon>
    @endfor
</div>
