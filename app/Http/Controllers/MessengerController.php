<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Http\Request;

class MessengerController extends Controller
{
    public function sendMessage(Request $request, Conversation $conversation)
    {
        $validated = $request->validate(['body' => 'required|string|max:2000']);

        // Перевірка доступу, щоб повідомлення не міг відправити хтось "лівий"
        if (! $conversation->participants()->where('user_id', auth()->id())->exists()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }

        $message = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'body' => $validated['body'],
        ]);

        // Завантажуємо дані автора для відображення
        $message->load('user');

        // Транслюємо подію іншим учасникам чату
        broadcast(new MessageSent($message))->toOthers();

        // Повертаємо створене повідомлення у форматі JSON
        // Це потрібно, щоб наш JavaScript міг миттєво його відобразити
        return response()->json($message);
    }

    public function startOrGetConversation(User $user)
    {
        $currentUser = auth()->user();

        $conversation = $currentUser->conversations()
            ->whereHas('participants', function ($query) use ($user) {
                $query->where('user_id', $user->id);
            })
            ->withCount('participants')
            ->having('participants_count', 2)
            ->first();

        if (!$conversation) {
            $conversation = Conversation::create();
            $conversation->participants()->attach([$currentUser->id, $user->id]);
        }

        return redirect()->route('chat.show', $conversation);
    }

    public function showConversation(Conversation $conversation)
    {
        abort_if(!$conversation->participants->contains(auth()->id()), 403);

        $messages = $conversation->messages()->latest()->take(50)->get()->reverse();

        return view('chat.show', [
            'conversation' => $conversation,
            'messages' => $messages
        ]);
    }
}