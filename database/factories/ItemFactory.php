<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Product;
use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Item>
 */
class ItemFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        // Factory needs to be called after Project Category and Product are already in DB.

        return [
            'project_id' => fake()->randomElement(Project::all()->pluck('id')),
            'category_id' => fake()->randomElement(Category::all()->pluck('id')),
            'product_id' => fake()->randomElement(Product::all()->pluck('id')),
            'name' => fake()->word(),
            'descriptions' => fake()->randomElements(
                [
                    [
                        'lang' => fake()->randomElement(['en', 'de', 'pl']),
                        'name' => fake()->word(),
                        'description' => fake()->text(50)
                    ],
                    [
                        'lang' => fake()->randomElement(['en', 'de', 'pl']),
                        'name' => fake()->word(),
                        'description' => fake()->text(50)
                    ],
                    [
                        'lang' => fake()->randomElement(['en', 'de', 'pl']),
                        'name' => fake()->word(),
                        'description' => fake()->text(50)
                    ]
                ],
                random_int(1, 3)
            ),
            'quantities' => fake()->randomElement([
                ["100", "200", "300"],
                ["50", "100", "150"],
                ["1000", "1500", "2000"],
                ["5000", "10000", "20000"]
            ])
        ];
    }
}
