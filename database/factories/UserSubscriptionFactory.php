<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserSubscriptionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // ВАЖЛИВО: Ми не створюємо нових юзерів тут.
            // ID користувачів (хто підписався і на кого) будуть передані з сідера.
            // Це правильний підхід, щоб зв'язати вже існуючих користувачів.
            'user_id' => User::factory(),
            'subscribed_to_id' => User::factory(),
            'is_accepted' => fake()->boolean(80), // 80% шанс, що підписка прийнята
        ];
    }
}
