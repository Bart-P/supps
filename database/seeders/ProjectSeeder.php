<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::factory()->createMany([
            [
                'name' => 'Tiny Love Display',
                'ext_id' => 'DORE-205',
            ],
            [
                'name' => 'Geske Displays',
                'ext_id' => '3A-203',
            ],
            [
                'name' => 'Recyclingbox Re-Order',
                'ext_id' => 'BRT-129',
            ],
            [
                'name' => '3D-Logoaufsteller waldläufer',
                'ext_id' => 'LUGI-215',
            ],
            [
                'name' => 'Seat Stands',
                'ext_id' => 'DORE-163',
            ],
            [
                'name' => 'Wandbedienplatz - Kom- Hartwick',
                'ext_id' => 'BÄCH-209',
            ],
        ]);
    }
}
