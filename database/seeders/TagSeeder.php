<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        Tag::factory()->createMany([
            ['name' => 'Großformat'],
            ['name' => 'Kleinformat'],
            ['name' => 'Schnell'],
            ['name' => 'Langsam'],
        ]);
    }
}
