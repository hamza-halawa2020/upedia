<?php

namespace Database\Seeders;

use App\Models\AcademyCategoryProduct;
use Illuminate\Database\Seeder;

class AcademyCategoryProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'id' => 1,
                'name_en' => 'extra sessions',
                'name_ar' => 'extra sessions',
                'slug' => 'extra-sessions',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 2,
                'name_en' => 'demo',
                'name_ar' => 'demo',
                'slug' => 'demo',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 3,
                'name_en' => 'english club',
                'name_ar' => 'english club',
                'slug' => 'english-club',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'id' => 4,
                'name_en' => 'gift call',
                'name_ar' => 'gift call',
                'slug' => 'gift-call',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        foreach ($categories as $category) {
            AcademyCategoryProduct::updateOrCreate(
                ['id' => $category['id']],
                $category,
            );
        }
    }
}
