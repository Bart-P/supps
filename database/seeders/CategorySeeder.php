<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Category::factory()->createMany([
            ['name' => 'Kartonage'],
            ['name' => 'Acryl'],
            ['name' => 'Möbelbau'],
            ['name' => 'Grafik Design'],
            ['name' => 'Metall'],
            ['name' => 'Messebau'],
            ['name' => 'Werbeartikel'],
            ['name' => 'Textil'],
            ['name' => 'Druck'],
        ]);
    }
}
