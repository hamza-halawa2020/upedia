@extends('layout.layout')
@section('content')
    <div class="app-bg">
        <div class="page-shell space-y-4">
            <x-page-title title="IT Expenses">@can('it_expenses_create')<x-table-action type="create"
            :url="route('it.expenses.create')" label="Add Expense" />@endcan</x-page-title>
            @include('components.alert')
            @if($errors->any())
                <ul>@foreach($errors->all() as $error)
                <li>{{ $error }}</li>@endforeach
            </ul>@endif
            <x-table-controls :action="route('it.expenses.index')">
                <button class="btn btn-outline-success" formaction="{{ route('it.expenses.export') }}" name="format"
                    value="xlsx">Excel</button>
                <button class="btn btn-outline-success" formaction="{{ route('it.expenses.export') }}" name="format"
                    value="csv">CSV</button>
                <button class="btn btn-outline-primary" formaction="{{ route('it.expenses.saveFilteredTable') }}"
                    title="Save table"><iconify-icon icon="lucide:save"></iconify-icon></button>
                <button type="submit" class="btn btn-outline-success" formaction="{{ route('it.expenses.export') }}"
                    name="format" value="pdf">PDF</button>
            </x-table-controls>
            <div class="ui-table-wrap">
                <table class="ui-table">
                    <thead>
                        <tr>
                            <th>Item</th>
                            <th>Vendors</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($expenses as $expense)
                            <tr>
                                <td>{{ $expense->item_name }}</td>
                                <td>{{ $expense->vendors }}</td>
                                <td>{{ $expense->amount }}</td>
                                <td>{{ $expense->status }}</td>
                                <td>
                                    @can('it_expenses_show')<x-table-action type="view" :url="route('it.expenses.show', $expense->id)" />@endcan
                                    @if($expense->status !== 'paid')
                                        @can('it_expenses_edit')<x-table-action type="edit" :url="route('it.expenses.edit', $expense->id)" />@endcan
                                        @can('it_expenses_destroy')
                                            <form class="d-inline" method="POST"
                                                action="{{ route('it.expenses.destroy', $expense->id) }}"
                                                onsubmit="return confirm('Delete this expense?')">
                                                @csrf @method('DELETE')<x-table-action type="delete" buttonType="submit" />
                                        </form>@endcan
                                    @endif
                                </td>
                        </tr>@empty <tr>
                            <td colspan="5">No expenses found.</td>
                        </tr>@endforelse
                    </tbody>
                </table>
            </div>{{ $expenses->links() }}
        </div>
    </div>
@endsection