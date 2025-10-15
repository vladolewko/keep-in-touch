<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicationFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'title' => ucfirst(fake()->words(fake()->numberBetween(3, 8), true)),
            'description' => fake()->realText(fake()->numberBetween(200, 800)),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
