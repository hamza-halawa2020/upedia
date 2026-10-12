<?php

namespace Database\Seeders;

use App\Models\AcademyCategoryProduct;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AcademyProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'id' => 1,
                'name_en' => 'extra session',
                'name_ar' => 'extra session',
                'slug' => 'extra-session',
                'price' => '450',
                'category_product_id' => AcademyCategoryProduct::where('slug', 'extra-sessions')->firstOrFail()->id,
                'created_at' => now(),
                'updated_at' => now(),
                'color' => '#119776',
                'count_of_students' => '1',
                'can_delete' => 'no',
            ],
            [
                'id' => 2,
                'name_en' => 'demo',
                'name_ar' => 'demo',
                'slug' => 'demo',
                'price' => '250',
                'category_product_id' => AcademyCategoryProduct::where('slug', 'demo')->firstOrFail()->id,
                'created_at' => now(),
                'updated_at' => now(),
                'color' => '#10d56f',
                'count_of_students' => '1',
                'can_delete' => 'no',
            ],
            [
                'id' => 3,
                'name_en' => 'english club',
                'name_ar' => 'english club',
                'slug' => 'english-club',
                'price' => '450',
                'category_product_id' => AcademyCategoryProduct::where('slug', 'english-club')->firstOrFail()->id,
                'created_at' => now(),
                'updated_at' => now(),
                'color' => '#971137',
                'count_of_students' => '5',
                'can_delete' => 'no',
            ],
            [
                'id' => 4,
                'name_en' => 'gift call',
                'name_ar' => 'gift call',
                'slug' => 'gift-call',
                'price' => '450',
                'category_product_id' => AcademyCategoryProduct::where('slug', 'gift-call')->firstOrFail()->id,
                'created_at' => now(),
                'updated_at' => now(),
                'color' => '#FF7800',
                'count_of_students' => '1',
                'can_delete' => 'no',
            ],
        ];

        foreach ($products as $product) {
            DB::table('academy_products')->updateOrInsert(
                ['id' => $product['id']],
                $product,
            );
        }
    }
}
