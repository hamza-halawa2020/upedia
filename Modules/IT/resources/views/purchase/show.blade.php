@extends('layout.layout')
@section('content')
<div class="app-bg"><div class="page-shell space-y-4">
    <x-page-title :title="$purchase->name" />
    <dl><dt>Number</dt><dd>{{ $purchase->purchase_number }}</dd><dt>Status</dt><dd>{{ $purchase->status }}</dd>
        <dt>Total</dt><dd>{{ $purchase->total }}</dd><dt>Vendors</dt><dd>{{ $purchase->vendors->pluck('name')->join(', ') }}</dd></dl>
    <div class="ui-table-wrap"><table class="ui-table"><thead><tr><th>Product</th><th>Quantity</th><th>Price</th><th>Tax (%)</th><th>Amount</th></tr></thead><tbody>
        @foreach($purchase->details as $item)<tr><td>{{ $item->product_name }}</td><td>{{ $item->quantity }}</td><td>{{ $item->price }}</td><td>{{ $item->tax_rate }}</td><td>{{ $item->amount }}</td></tr>@endforeach
    </tbody></table></div>
    <a href="{{ route('it.purchase.index') }}">Back</a>
</div></div>
@endsection
