@extends('layout.layout')

@section('content')
@include('marketing::scripts.partials.index.content-1')
    @php
        $filters = [];

        $user = Auth::user();
        $departmentSlug = optional($user?->staff?->department)->slug;

        if ($user?->hasRole('Super admin') || $departmentSlug === 'marketing') {
            $filters['department_id'] = $departments->pluck('name', 'id')->toArray();

            $filters['visibility'] = [
                'public' => 'Public',
                'private' => 'Private',
            ];

            $filters['status'] = [
                'approved' => 'Approved',
                'unapproved' => 'Unapproved',
            ];
        }
    @endphp
@include('marketing::scripts.partials.index.content-2')
@endsection

@push('styles')
@include('marketing::scripts.partials.index.styles-3')
@endpush
