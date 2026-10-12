@extends('layout.layout')

@section('content')
@include('marketing::scripts.partials.edit.content-1')

@endsection

@push('styles')
@include('marketing::scripts.partials.edit.styles-2')
@endpush

@push('scripts')
@include('marketing::scripts.partials.edit.scripts-3')
@endpush
