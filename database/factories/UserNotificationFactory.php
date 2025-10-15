<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserNotificationFactory extends Factory
{
    /**
     * Define the model's default state.
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // ID відправника та отримувача будуть передані з сідера.
            // Робити запити до БД всередині фабрики - дуже погана практика для продуктивності.
            'user_id' => User::factory(), // Хто відправив
            'sended_to_id' => User::factory(), // Кому відправили
            'topic' => fake()->randomElement(['warning', 'block', 'message', 'notification']),
            'message' => fake()->sentence(),
            'is_read' => fake()->boolean(30), // 30% шанс, що повідомлення прочитане
        ];
    }
}
