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
                'project_id' => 'DORE-205',
            ],
            [
                'name' => 'Geske Displays',
                'project_id' => '3A-203',
            ],
            [
                'name' => 'Recyclingbox Re-Order',
                'project_id' => 'BRT-129',
            ],
            [
                'name' => '3D-Logoaufsteller waldläufer',
                'project_id' => 'LUGI-215',
            ],
            [
                'name' => 'Seat Stands',
                'project_id' => 'DORE-163',
            ],
            [
                'name' => 'Wandbedienplatz - Kom- Hartwick',
                'project_id' => 'BÄCH-209',
            ],
        ]);
    }
}
