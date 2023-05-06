<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Client>
 */
class ClientFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => fake()->name(),
            'id_number' => fake()->text(),
            'dob' => fake()->date(),
            'ec_number' => fake()->numberBetween(1000, 9999),
            'type' => fake()->text(),
            'battery_number' => fake()->numberBetween(100000000, 999999999),
            'created_by' => fake()->name(),
        ];
    }
}
