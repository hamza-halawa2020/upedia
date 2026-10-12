@extends('layout.layout')

@section('content')
@include('marketing::plans.partials.show.content-1')
                                    @php
                                        $statusClass = match ($plan->status) {
                                            'draft' => 'ui-pill--neutral',
                                            'under-review' => 'ui-pill--info',
                                            'ready-to-publish' => 'ui-pill--primary',
                                            'not-approved' => 'ui-pill--danger',
                                            'published' => 'ui-pill--success',
                                            default => 'ui-pill--neutral',
                                        };
                                    @endphp
@include('marketing::plans.partials.show.content-2')
@endsection

@push('styles')
@include('marketing::plans.partials.show.styles-3')
@include('marketing::plans.partials.show.content-4')
@endpush
