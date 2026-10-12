<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ReferralSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $settings = [
            [
                'id' => 1,
                'referrer_discount' => '50.00',
                'referred_discount' => '10.00',
                'product_type' => null,
                'product_id' => null,
                'product_category_id' => null,
                'discount_type' => 'percentage',
                'created_by' => 1,
                'discount' => 50,
                'expire_day' => 0,
            ],
        ];

        foreach ($settings as $setting) {
            $setting['created_by'] = $this->optionalUserId($setting['created_by']);
            $setting['created_at'] = now();
            $setting['updated_at'] = now();

            DB::table('referral_settings')->updateOrInsert(
                ['id' => $setting['id']],
                $setting
            );
        }
    }

    private function optionalUserId(?int $userId): ?int
    {
        return $userId ? User::find($userId)?->id : null;
    }
}
