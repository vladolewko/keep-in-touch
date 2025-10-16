<?php

use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

// Правильна перевірка доступу до чату
Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    if ($user->conversations()->where('conversation_id', $conversationId)->exists()) {
        // Ось тут ми повертаємо дані на фронтенд
        return ['id' => $user->id, 'name' => $user->nickname]; // Використовуємо nickname
    }
});