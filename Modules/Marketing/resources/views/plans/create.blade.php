@extends('layout.layout')

@section('content')
@include('marketing::plans.partials.create.content-1')
@include('marketing::plans.partials.create.content-2')
@endsection

@push('styles')
@include('marketing::plans.partials.create.styles-3')
@endpush
