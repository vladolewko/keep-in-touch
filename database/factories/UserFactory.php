<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected static ?string $password;

    /**
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->firstName(),
            'surname' => fake()->lastName(),
            'nickname' => fake()->unique()->userName(),
            'phone' => fake()->unique()->e164PhoneNumber(),
            'bio' => fake()->realText(150),
            'address' => fake()->address(),
            'is_private' => fake()->boolean(25),
            'role' => 'user',
            'email' => fake()->unique()->safeEmail(),
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'remember_token' => Str::random(10),
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