@extends('layout.layout')

@section('content')
@include('marketing::plans.partials.calendar.content-1')
                                    @php
                                        $statuses = [
                                            'draft',
                                            'under-review',
                                            'ready-to-publish',
                                            'not-approved',
                                            'published',
                                        ];
                                    @endphp
@include('marketing::plans.partials.calendar.content-2')
                                    @php
                                        $platforms = ['facebook', 'instagram', 'tiktok', 'youtube', 'X', 'snapchat'];
                                    @endphp
@include('marketing::plans.partials.calendar.content-3')
@endsection

@push('styles')
@include('marketing::plans.partials.calendar.styles-4')
@include('marketing::plans.partials.calendar.content-5')
@endpush

@push('scripts')
@include('marketing::plans.partials.calendar.scripts-6')
@include('marketing::plans.partials.calendar.content-7')
@endpush
