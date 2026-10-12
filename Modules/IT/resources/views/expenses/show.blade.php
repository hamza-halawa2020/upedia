@extends('layout.layout')
@section('content')
    <div class="app-bg">
        <div class="page-shell">
            <x-page-title :title="$expense->item_name" />
            <dl>@foreach($expense->only(['amount', 'vendors', 'status', 'payment_method', 'recurring']) as $field => $value)
                <dt>{{ ucwords(str_replace('_', ' ', $field)) }}</dt>
                <dd>{{ $value }}</dd>
            @endforeach
            </dl>
            <a href="{{ route('it.expenses.index') }}">Back</a>
        </div>
    </div>
@endsection