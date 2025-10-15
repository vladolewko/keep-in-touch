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
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // ID публікації та користувача будуть передаватися з сідера
            'publication_id' => Publication::factory(),
            'user_id' => User::factory(),
            'comment' => fake()->realText(rand(50, 250)),
            // Поле 'likes' має значення за замовчуванням (0), тому його тут не вказуємо.
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
