<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class AddressFactory extends Factory
{
    public function definition(): array
    {
        return [
            'name1' => fake()->company(),
            'name2' => fake()->name(),
            'street' => fake()->streetName(),
            'street_nr' => fake()->numberBetween(1, 200),
            'city_code' => fake()->numberBetween(10000, 99999),
            'city' => fake()->city(),
            'country' => fake()->country(),
            'phone' => fake()->phoneNumber(),
        ];
    }
}
