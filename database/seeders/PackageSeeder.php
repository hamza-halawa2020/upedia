<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $packages = [
            ['id' => 1, 'name' => '1 Month', 'levels_count' => 1, 'status' => 'active', 'display_order' => 1],
            ['id' => 2, 'name' => '3 Months', 'levels_count' => 3, 'status' => 'active', 'display_order' => 2],
            ['id' => 3, 'name' => '6 Months', 'levels_count' => 6, 'status' => 'active', 'display_order' => 3],
            ['id' => 4, 'name' => '12 Months', 'levels_count' => 12, 'status' => 'active', 'display_order' => 4],
        ];

        foreach ($packages as $package) {
            Package::updateOrCreate(
                ['id' => $package['id']],
                [
                    ...$package,
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
            );
        }
    }
}
