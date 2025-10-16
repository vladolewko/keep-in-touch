<?php

use Illuminate\Support\Facades\Broadcast;


Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    if ($user->conversations()->where('conversation_id', $conversationId)->exists()) {
        return ['id' => $user->id, 'name' => $user->nickname];
    }
});