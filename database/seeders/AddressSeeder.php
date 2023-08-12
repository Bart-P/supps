<?php

namespace Database\Seeders;

use App\Models\Address;
use App\Models\Supplier;
use Illuminate\Database\Seeder;

class AddressSeeder extends Seeder
{
    # Needs to be called after Suppliers are created
    public function run(): void
    {
        $suppliers = Supplier::all();

        $suppliers->each(function ($supp) {
            Address::factory()->create([
                'supplier_id' => $supp->id,
                'name1' => $supp->name,
                'type' => 'main',
            ]);

            if (random_int(1, 3) < 3) {
                Address::factory()->create([
                    'supplier_id' => $supp->id,
                    'type' => fake()->randomElement(['invoice', 'delivery', 'other']),
                ]);
            }
        });
    }
}
