<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::factory()->createMany([
            [
                'name' => 'Thekenaufsteller',
                'category_id' => 1,
            ],
            [
                'name' => 'Warenträger',
                'category_id' => 1,
            ],
            [
                'name' => 'Ellipse',
                'category_id' => 1,
            ],
            [
                'name' => 'Vollpappe',
                'category_id' => 1,
            ],
            [
                'name' => 'Flyer',
                'category_id' => 1,
            ],
            [
                'name' => 'Plakate',
                'category_id' => 1,
            ],
            [
                'name' => 'Thekenaufsteller',
                'category_id' => 2,
            ],
            [
                'name' => 'Bodenaufsteller',
                'category_id' => 2,
            ],
            [
                'name' => 'Schrank',
                'category_id' => 3,
            ],
            [
                'name' => 'Blech',
                'category_id' => 4,
            ],
            [
                'name' => 'Draht',
                'category_id' => 4,
            ],
            [
                'name' => 'Aufkleber',
                'category_id' => 9,
            ],
            [
                'name' => 'PVC',
                'category_id' => 9,
            ],
            [
                'name' => 'Außenbanner',
                'category_id' => 9,
            ],
        ]);
    }
}
