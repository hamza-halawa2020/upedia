@extends('layout.layout')

@section('content')
@include('marketing::scripts.partials.show.content-1')
                            @php
                                $statusClass = $scr->status === 'approved' ? 'bg-success' : 'bg-warning text-dark';
                                $statusIcon = $scr->status === 'approved' ? 'fa-check-circle' : 'fa-hourglass-start';
                            @endphp
@include('marketing::scripts.partials.show.content-2')
                            @php
                                $visibilityClass = $scr->visibility === 'public' ? 'text-success bg-success-subtle' : 'text-secondary bg-secondary-subtle';
                                $visibilityIcon = $scr->visibility === 'public' ? 'fa-globe' : 'fa-lock';
                            @endphp
@include('marketing::scripts.partials.show.details')
@endsection
