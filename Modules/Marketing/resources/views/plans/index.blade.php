@extends('layout.layout')

@section('content')
@include('marketing::plans.partials.index.content-1')
    @php
        $filters = [
            'platform' => [
                'facebook' => 'Facebook',
                'instagram' => 'Instagram',
                'tiktok' => 'TikTok',
                'youtube' => 'YouTube',
                'X' => 'X',
                'snapchat' => 'Snapchat',
            ],
            'status' => [
                'draft' => 'Draft',
                'under-review' => 'Under Review',
                'ready-to-publish' => 'Ready To Publish',
                'not-approved' => 'Not Approved',
                'published' => 'Published',
            ],
            'type' => [
                'script' => 'Script',
                'content_plan' => 'Content Plan',
                'design' => 'Design',
                'video' => 'Video',
            ],
        ];
    @endphp
@include('marketing::plans.partials.index.content-2')
@endsection

@push('styles')
@include('marketing::plans.partials.index.styles-3')
@endpush
