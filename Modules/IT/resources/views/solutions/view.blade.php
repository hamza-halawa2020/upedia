@extends('layout.layout')
@section('content')
<div class="app-bg"><div class="page-shell space-y-4">
    <x-page-title :title="$solution->title" />
    <h2>{{ $solution->topic_name }}</h2>
    <div style="white-space: pre-wrap">{{ $solution->description }}</div>
    <p>{{ $solution->keywords }}</p>
    <a href="{{ route('it.solutions.browse') }}">Back</a>
</div></div>
@endsection
