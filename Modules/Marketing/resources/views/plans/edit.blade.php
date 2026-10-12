@extends('layout.layout')

@section('content')
@include('marketing::plans.partials.edit.content-1')
@include('marketing::plans.partials.edit.content-2')
@include('marketing::plans.partials.edit.content-3')
@endsection

@push('styles')
@include('marketing::plans.partials.edit.styles-4')
@include('marketing::plans.partials.edit.content-5')
@endpush
