@extends('layout.layout')

@php
    $sectionDescriptions = [
       
    ];

    $topPlanPlatform = collect(data_get($sections, 'plans.left.list', []))->first();
    $topComplaintPriority = collect(data_get($sections, 'overview.right.list', []))->first();
    $topLeadSource = collect(data_get($sections, 'leads.left.list', []))->first();
    $overviewStatus = collect(data_get($sections, 'performance.right.list', []))->take(5)->all();
    $overviewStatusSuffix = data_get($sections, 'performance.right.chart.suffix', '');

    $insightCards = [
        [
            'label' => 'Top Plan Platform',
            'title' => data_get($topPlanPlatform, 'label', 'No Data'),
            'meta' => data_get($topPlanPlatform, 'value', 0) . ' plans',
            'url' => data_get($topPlanPlatform, 'url'),
        ],
        [
            'label' => 'Top Complaint Priority',
            'title' => data_get($topComplaintPriority, 'label', 'No Data'),
            'meta' => data_get($topComplaintPriority, 'value', 0) . ' complaints',
            'url' => data_get($topComplaintPriority, 'url'),
        ],
        [
            'label' => 'Top Lead Source',
            'title' => data_get($topLeadSource, 'label', 'No Data'),
            'meta' => data_get($topLeadSource, 'value', 0) . ' leads',
            'url' => data_get($topLeadSource, 'url'),
        ],
    ];
@endphp

@push('styles')
    <style>
@include('marketing::reports.partials.styles-base')
@include('marketing::reports.partials.styles-charts')
    </style>
@endpush

@section('content')
@include('marketing::reports.partials.content')
@endsection

@push('scripts')
@include('marketing::reports.partials.scripts')
@endpush
