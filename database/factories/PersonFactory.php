<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Person>
 */
class PersonFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'type' => fake()->randomElement(['main', 'backup', 'other']),
            'gender' => fake()->randomElement(['male', 'female', 'other']),
            'first_name' => fake()->firstName(),
            'last_name' => fake()->lastName(),
            'position' => fake()->randomElement(['Trade Marketing', 'Product Manager', 'Purchasing', '']),
            'phone1' => fake()->phoneNumber(),
            'phone2' => fake()->phoneNumber(),
            'email1' => fake()->email(),
        ];
    }
}
