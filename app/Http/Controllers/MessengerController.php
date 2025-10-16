<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\User;
use App\Repositories\ConversationRepository;
use App\Services\MessengerService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

/** Class MessengerController */
class MessengerController extends Controller
{
    /**
     * @param MessengerService       $messengerService
     * @param ConversationRepository $conversationRepository
     */
    public function __construct(
        protected MessengerService       $messengerService,
        protected ConversationRepository $conversationRepository,
    ) {}

    /** @return View */
    public function index(): View
    {
        $conversations = $this->conversationRepository->getUserConversations(auth()->user());
        return view('chats.index', compact('conversations'));
    }

    /**
     * @param Conversation $conversation
     * @return View
     */
    // app/Http/Controllers/MessengerController.php
    public function showConversation(Conversation $conversation): View
    {
        abort_if(!$conversation->participants->contains(auth()->id()), 403);
        $messages = $this->conversationRepository->getMessages($conversation, auth()->user());

        return view('chats.show', compact('conversation', 'messages'));
    }

    /**
     * @param User $user
     * @return RedirectResponse
     */
    public function startOrGetConversation(User $user): RedirectResponse
    {
        $conversation = $this->messengerService->startOrGetConversation(auth()->user(), $user);
        return redirect()->route('chat.show', $conversation);
    }

    /**
     * @param Request      $request
     * @param Conversation $conversation
     * @return JsonResponse
     */
    public function sendMessage(Request $request, Conversation $conversation): JsonResponse
    {
        $validated = $request->validate(['body' => 'required|string|max:2000']);
        abort_if(!$conversation->participants->contains(auth()->id()), 403);
        $message = $this->messengerService->sendMessage($conversation, auth()->user(), $validated);

        return response()->json($message);
    }

    /**
     * @param Request      $request
     * @param Conversation $conversation
     * @return RedirectResponse
     */
    public function destroy(Request $request, Conversation $conversation): RedirectResponse
    {
        abort_if(!$conversation->participants->contains(auth()->id()), 403);

        $this->messengerService->deleteConversation(
            $conversation,
            auth()->user(),
            $request->has('for_both'),
        );

        return redirect()->route('chats.index')->with('status', 'Chat deleted successfully!');
    }

    /**
     * @param Conversation $conversation
     * @return JsonResponse
     */
    public function markAsRead(Conversation $conversation): JsonResponse
    {
        abort_if(!$conversation->participants->contains(auth()->id()), 403);
        $newCount = $this->messengerService->markAsRead($conversation, auth()->user());
        return response()->json(['total_unread' => $newCount]);
    }
}