<?php

namespace Database\Factories;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserPublicationLikeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Аналогічно до підписок, ID користувача та публікації
            // будуть передаватися з сідера для зв'язку існуючих записів.
            'user_id' => User::factory(),
            'publication_id' => Publication::factory(),
        ];
    }
}
