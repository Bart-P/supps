<?php

namespace Database\Seeders;

use App\Models\Person;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class PersonSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $suppliers = Supplier::all();

        $suppliers->each(function ($supp) {
            Person::factory()->create([
                'supplier_id' => $supp->id,
                'type' => 'main',
            ]);

            if (random_int(1, 3) < 3) {
                Person::factory()->create([
                    'supplier_id' => $supp->id,
                    'type' => fake()->randomElement(['backup', 'other']),
                ]);
            }
        });
    }
}
