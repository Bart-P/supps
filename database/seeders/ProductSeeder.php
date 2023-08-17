<?php

namespace Database\Seeders;

use App\Models\Product;
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
            ],
            [
                'name' => 'Warenträger',
            ],
            [
                'name' => 'Ellipse',
            ],
            [
                'name' => 'Vollpappe',
            ],
            [
                'name' => 'Flyer',
            ],
            [
                'name' => 'Plakate',
            ],
            [
                'name' => 'Schrank',
            ],
            [
                'name' => 'Blech',
            ],
            [
                'name' => 'Draht',
            ],
            [
                'name' => 'Aufkleber',
            ],
            [
                'name' => 'PVC',
            ],
            [
                'name' => 'Außenbanner',
            ],
        ]);
    }
}
