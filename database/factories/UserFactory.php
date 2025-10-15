<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            // Створюємо унікальний та більш реалістичний нікнейм
            'nickname' => fake()->unique()->userName(),
            'phone' => fake()->unique()->e164PhoneNumber(),
            // Генеруємо більш осмислений опис профілю
            'bio' => fake()->realText(150),
            'address' => fake()->address(),
            // Додаємо випадковість для приватних акаунтів
            'is_private' => fake()->boolean(25), // 25% шанс, що акаунт буде приватним
            'role' => 'user', // За замовчуванням всі користувачі - 'user'
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
            // Додаємо випадкову дату реєстрації для реалістичності
            'created_at' => fake()->dateTimeBetween('-2 years', 'now'),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * Стан для створення адміністратора.
     * Це дозволяє легко створювати адмінів у сідері: User::factory()->admin()->create();
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'admin',
            'is_private' => false, // Адміни не можуть бути приватними
        ]);
    }
}