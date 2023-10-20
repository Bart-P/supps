<?php

namespace Database\Factories;

use App\Models\Inquiry;
use App\Models\Item;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Inquiry>
 */
class InquiryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */

    public function definition(): array
    {
        $project_id = fake()->randomElement(Project::all()->pluck('id'));

        return [
            'project_id' => $project_id,
            'name' => fake()->sentence(random_int(1, 4)),
        ];
    }

    public function configure(): static
    {
        return $this->afterCreating(function (Inquiry $inquiry) {
            $new_items = Item::factory(random_int(1, 4))->create([
                'project_id' => $inquiry->project_id,
            ]);

            $inquiry->items()->attach($new_items);
        });
    }
}
