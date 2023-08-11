<?php

namespace Database\Seeders;

use App\Models\PrintType;
use Illuminate\Database\Seeder;

class PrintTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PrintType::factory()->createMany([
            ['name' => 'Suplimation'],
            ['name' => 'Tampon'],
            ['name' => 'Offset'],
            ['name' => 'Digital Rolle'],
            ['name' => 'Digital Direkt'],
            ['name' => 'Hot Stamping'],
            ['name' => 'UV Selektiv'],
        ]);
    }
}
