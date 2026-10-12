<?php

namespace Database\Seeders;

use App\Models\ChartOfAccount;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TreasurySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $treasuries = [
            [
                'id' => 4,
                'name' => 'CIB Treasury',
                'account_code' => '1111',
                'type' => 'Bank',
                'payment_flow' => 'manual',
                'payment_region' => 'both',
                'is_payment_available' => 0,
                'iban' => '',
                'bank_name' => 'CIB',
                'account_number' => '9999999999999999999',
                'has_insta_pay' => 0,
                'insta_pay_phone' => null,
                'opening_balance' => 500,
                'balance' => '5000.00',
                'currency' => 'EGP',
                'status' => 'Active',
                'is_active' => 1,
                'created_by' => 457,
            ],
            [
                'id' => 5,
                'name' => 'HSBC Treasury',
                'account_code' => '212',
                'type' => 'Bank',
                'payment_flow' => 'manual',
                'payment_region' => 'both',
                'is_payment_available' => 1,
                'iban' => null,
                'bank_name' => 'HSBC',
                'account_number' => '888888888888888888',
                'has_insta_pay' => 0,
                'insta_pay_phone' => null,
                'opening_balance' => 0,
                'balance' => '0.00',
                'currency' => '$',
                'status' => 'Active',
                'is_active' => 1,
                'created_by' => 457,
            ],
            [
                'id' => 11,
                'name' => 'kashier',
                'account_code' => '1111',
                'type' => 'Bank',
                'payment_flow' => 'online',
                'payment_region' => 'both',
                'is_payment_available' => 1,
                'iban' => null,
                'bank_name' => 'kashir',
                'account_number' => '9999999999999999999',
                'has_insta_pay' => 0,
                'insta_pay_phone' => null,
                'opening_balance' => 0,
                'balance' => '0.00',
                'currency' => 'EGP',
                'status' => 'Active',
                'is_active' => 1,
                'created_by' => 457,
            ],
            [
                'id' => 12,
                'name' => 'stripe',
                'account_code' => '1111',
                'type' => 'Bank',
                'payment_flow' => 'online',
                'payment_region' => 'both',
                'is_payment_available' => 1,
                'iban' => null,
                'bank_name' => 'paypal',
                'account_number' => '9999999999999999999',
                'has_insta_pay' => 0,
                'insta_pay_phone' => null,
                'opening_balance' => 0,
                'balance' => '22217.50',
                'currency' => 'EGP',
                'status' => 'Active',
                'is_active' => 1,
                'created_by' => 457,
            ],
        ];

        foreach ($treasuries as $treasury) {
            $treasury['account_id'] = ChartOfAccount::where('code', $treasury['account_code'])->firstOrFail()->id;
            unset($treasury['account_code']);

            $treasury['created_by'] = $this->optionalUserId($treasury['created_by']);
            $treasury['created_at'] = now();
            $treasury['updated_at'] = now();

            DB::table('treasuries')->updateOrInsert(
                ['id' => $treasury['id']],
                $treasury
            );
        }
    }

    private function optionalUserId(?int $userId): ?int
    {
        return $userId ? User::find($userId)?->id : null;
    }
}
