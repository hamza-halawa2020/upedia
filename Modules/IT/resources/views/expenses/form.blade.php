@extends('layout.layout')
@section('content')
    <div class="app-bg">
        <div class="page-shell">
            <x-page-title :title="$expense ? 'Edit Expense' : 'Add Expense'" />
            @if($errors->any())
                <ul>@foreach($errors->all() as $error)
                <li>{{ $error }}</li>@endforeach
            </ul>@endif
            <form method="POST"
                action="{{ $expense ? route('it.expenses.update', $expense->id) : route('it.expenses.store') }}">
                @csrf @if($expense) @method('PUT') @endif
                @foreach(['item_name' => 'Item', 'vendors' => 'Vendors', 'amount' => 'Amount', 'payment_date' => 'Payment Date', 'due_date' => 'Due Date'] as $field => $label)
                    <label class="form-label" for="{{ $field }}">{{ $label }}</label>
                    <input id="{{ $field }}" class="form-control mb-3" name="{{ $field }}"
                        value="{{ old($field, in_array($field, ['payment_date', 'due_date']) ? $expense?->{$field}?->format('Y-m-d') : $expense?->{$field}) }}"
                        type="{{ str_ends_with($field, '_date') ? 'date' : ($field === 'amount' ? 'number' : 'text') }}"
                        @if($field === 'amount') min="0" step="any" @endif @if($field !== 'due_date') required @endif>
                @endforeach
                @foreach(['payment_method' => ['petty_cash' => 'Petty Cash', 'finance_team' => 'Finance Team'], 'recurring' => ['one_time' => 'One Time', 'monthly' => 'Monthly', 'yearly' => 'Yearly']] as $field => $options)
                    <label class="form-label" for="{{ $field }}">{{ ucwords(str_replace('_', ' ', $field)) }}</label>
                    <select id="{{ $field }}" class="form-select mb-3" name="{{ $field }}" required>
                        @foreach($options as $value => $label)
                            <option value="{{ $value }}" @selected(old($field, $expense?->{$field}) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                @endforeach
                <label class="form-label" for="head">Expense Head</label>
                <select id="head" name="expense_head_id" class="form-select mb-3">
                    <option value="">Select expense head</option>
                    @foreach($heads as $head)
                    <option value="{{ $head->id }}" @selected(old('expense_head_id', $expense?->expense_head_id) == $head->id)>{{ $head->name }}</option>@endforeach
                </select>
                <button class="btn btn-primary" type="submit"><iconify-icon icon="lucide:save"></iconify-icon> Save</button>
                <a href="{{ route('it.expenses.index') }}" class="btn btn-outline-secondary">Cancel</a>
            </form>
        </div>
    </div>
@endsection