<?php

namespace Database\Factories;

use App\Models\Message;
use App\Models\User;
use App\Enums\MessageStatusEnum;
use Illuminate\Database\Eloquent\Factories\Factory;

class MessageFactory extends Factory
{
    protected $model = Message::class;

    public function definition(): array
    {
        return [
            'client_name' => fake()->name(),
            'email' => fake()->safeEmail(),
            'message' => fake()->paragraph(),
            'status' => MessageStatusEnum::Pending->value,
            'manager_id' => null,
            'answer' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function withManager(): self
    {
        return $this->state(function (array $attributes) {
            return [
                'manager_id' => User::factory(),
            ];
        });
    }
}
