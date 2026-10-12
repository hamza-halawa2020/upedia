@extends('layout.layout')

@section('content')
@include('marketing::complaints.partials.index.content-1')
    @php
        $filters = [
            'priority' => [
                'low' => 'Low',
                'medium' => 'Medium',
                'high' => 'High',
            ],
            'status' => [
                'not_solved' => 'Open',
                'solved' => 'Solved',
            ],
            'staff_id' => $salesStaff->pluck('full_name', 'id')->toArray(),
            'platform' => array_combine(
                ['facebook', 'tiktok', 'youtube', 'X', 'snapchat', 'instagram'],
                array_map('ucfirst', ['facebook', 'tiktok', 'youtube', 'X', 'snapchat', 'instagram'])
            ),
            'inside_outside' => [
                'inside' => 'Inside',
                'outside' => 'Outside',
            ],
            'department' => [
                'sales' => 'Sales',
                'retention' => 'Retention',
            ],
            'case_type' => [
                'complaint' => 'Complaint Case',
                'follow_up' => 'Follow-up Case',
            ],
        ];
    @endphp
@include('marketing::complaints.partials.index.content-2')
@endsection

@push('styles')
@include('marketing::complaints.partials.index.styles-3')
@endpush
