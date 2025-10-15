<?php

namespace Database\Factories;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PublicationComment>
 */
class PublicationCommentFactory extends Factory
{
    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'publication_id' => Publication::factory(),
            'user_id' => User::factory(),
            'comment' => fake()->realText(rand(50, 250)),
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
