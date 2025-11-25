<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class NotificationFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'sent_to_id' => User::factory(),
            'topic' => fake()->randomElement(['warning', 'block', 'message', 'notification']),
            'message' => fake()->sentence(),
            'is_read' => fake()->boolean(30),
        ];
    }
}
