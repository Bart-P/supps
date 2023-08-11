<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Bartek',
            'email' => 'bartek@mephistomedia.com',
        ]);

        $this->call([
            CategorySeeder::class,
            PrintTypeSeeder::class,
            ProductSeeder::class,
        ]);
    }
}
