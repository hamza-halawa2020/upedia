<?php

namespace Modules\IT\Purchases\Actions;

use App\Models\Purchase;
use App\Models\PurchaseDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SavePurchase
{
    public function handle(array $data, ?int $id = null): Purchase
    {
        return DB::transaction(function () use ($data, $id) {
            $purchase = $id ? Purchase::where('invoice_type', 'purchase')->lockForUpdate()->findOrFail($id) : new Purchase;
            if ($id && $purchase->status !== 'pending') {
                throw ValidationException::withMessages(['purchase' => 'Only pending purchases can be edited.']);
            }
            $rows = collect($data['items'])->map(function ($item) {
                $net = $item['qty'] * $item['unit_price'];

                return ['serial_number' => $item['serial_number'] ?? null, 'category_name' => $item['category'],
                    'product_name' => $item['product'], 'quantity' => $item['qty'], 'price' => $item['unit_price'],
                    'tax_rate' => $item['tax'] ?? 0, 'amount' => round($net * (1 + ($item['tax'] ?? 0) / 100), 2)];
            });
            $subtotal = $rows->sum('amount');
            $shipping = $data['shipping_cost'] ?? 0;
            $purchase->fill(['purchase_number' => $data['purchase_number'], 'name' => $data['name'],
                'required_by' => $data['required_by'], 'cost_center_id' => $data['cost_center_id'] ?? null,
                'sub_total' => $subtotal, 'shipping_cost' => $shipping, 'total' => $subtotal + $shipping,
                'invoice_type' => 'purchase']);
            if (! $id) {
                $purchase->status = 'pending';
            }
            $purchase->save();
            $purchase->details()->delete();
            $now = now();
            $rows = $rows->map(fn ($row) => $row + ['purchase_id' => $purchase->id, 'created_at' => $now, 'updated_at' => $now]);
            DB::table((new PurchaseDetail)->getTable())->insert($rows->all());
            $purchase->requestedStaffs()->sync([$data['staff_id']]);
            $purchase->vendors()->sync($data['vendor_ids']);

            return $purchase;
        });
    }
}
