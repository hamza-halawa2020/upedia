@extends('layout.layout')

@section('content')
@include('marketing::complaints.partials.show.content-1')
                                    @php
                                        $priorityClass = match ($complain->priority) {
                                            'high' => 'ui-pill--danger',
                                            'medium' => 'ui-pill--warn',
                                            'low' => 'ui-pill--success',
                                            default => 'ui-pill--neutral',
                                        };
                                    @endphp
@include('marketing::complaints.partials.show.content-2')
                                    @php
                                        $statusClass = match ($complain->status) {
                                            'solved' => 'ui-pill--success',
                                            'not_solved' => 'ui-pill--danger',
                                            default => 'ui-pill--neutral',
                                        };
                                    @endphp
@include('marketing::complaints.partials.show.content-3')
@endsection

@push('styles')
@include('marketing::complaints.partials.show.styles-4')
@include('marketing::complaints.partials.show.content-5')
@endpush
