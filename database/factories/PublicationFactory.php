<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class PublicationFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Замість створення нового юзера, ми будемо прив'язувати публікацію
            // до вже існуючого юзера в сідері. Це значно ефективніше.
            'user_id' => User::factory(),
            'title' => ucfirst(fake()->words(fake()->numberBetween(3, 8), true)), // Більш реалістичні заголовки
            'description' => fake()->realText(fake()->numberBetween(200, 800)), // І більш реалістичний опис
            // Поля 'likes' та 'reposts' - це лічильники. Їх не потрібно заповнювати через фабрику.
            // Вони мають оновлюватися логікою вашого додатку (наприклад, через відносини або тригери).
            // Тому я їх видалив звідси.
            'created_at' => fake()->dateTimeBetween('-1 year', 'now'),
        ];
    }
}
