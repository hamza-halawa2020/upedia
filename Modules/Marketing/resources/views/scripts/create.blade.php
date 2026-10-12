@extends('layout.layout')

@section('content')
@include('marketing::scripts.partials.create.content-1')
@endsection

@push('styles')
@include('marketing::scripts.partials.create.styles-2')
@endpush

@push('scripts')
@include('marketing::scripts.partials.create.scripts-3')
@endpush
