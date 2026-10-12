@extends('layout.layout')
@section('content')
    <div class="app-bg">
        <div class="page-shell space-y-4">
            <x-page-title title="IT" />
            <nav class="d-flex gap-3 flex-wrap">
                @foreach(['it.tickets.index' => ['Tickets', 'it_tickets_index'], 'it.asset.index' => ['Assets', 'it_assets_index'], 'it.purchase.index' => ['Purchases', 'it_purchase_index'], 'it.expenses.index' => ['Expenses', 'it_expenses_index'], 'it.vendors.index' => ['Vendors', 'it_vendors_index'], 'it.dashboard' => ['Statistics', 'it_dashboard_index'], 'it.assetDashboard' => ['Asset Statistics', 'it_assets_index']] as $route => [$label, $permission])
                    @can($permission)<a href="{{ route($route) }}">{{ $label }}</a>@endcan
                @endforeach
                <a href="{{ route('it.solutions.browse') }}">Solutions</a>
            </nav>
        </div>
    </div>
@endsection