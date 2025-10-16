<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Conversation;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Contracts\View\Factory;

/** Class MessengerController */
class MessengerController extends Controller
{
    /** @return Factory|View|Application|object */
    public function index()
    {
        $user = auth()->user();

        $conversations = $user->conversations()
            ->with(['participants' => function ($query) use ($user) {
                $query->where('user_id', '!=', $user->id);
            }])
            ->latest('updated_at')
            ->get();

        return view('chats.index', [
            'conversations' => $conversations,
        ]);
    }

    /**
     * @param Request      $request
     * @param Conversation $conversation
     * @return JsonResponse
     */
    public function sendMessage(Request $request, Conversation $conversation): JsonResponse
    {
        $validated = $request->validate(['body' => 'required|string|max:2000']);
        if (!$conversation->participants()->where('user_id', auth()->id())->exists()) {
            return response()->json(['message' => 'Forbidden'], 403);
        }
        $message = $conversation->messages()->create([
            'user_id' => auth()->id(),
            'body'    => $validated['body'],
        ]);
        $message->load('user');
        broadcast(new MessageSent($message))->toOthers();

        return response()->json($message);
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function startOrGetConversation(User $user): RedirectResponse
    {
        $currentUser  = auth()->user();
        $conversation = $currentUser
            ->conversations()
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

    /**
     * @param Conversation $conversation
     * @return Factory|View|Application|object
     */
    public function showConversation(Conversation $conversation)
    {
        abort_if(!$conversation->participants->contains(auth()->id()), 403);

        $messages = $conversation->messages()->latest()->take(50)->get()->reverse();

        return view('chats.show', [
            'conversation' => $conversation,
            'messages'     => $messages,
        ]);
    }
}