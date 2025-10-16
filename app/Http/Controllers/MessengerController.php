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
    public function showConversation(Conversation $conversation): View
    {
        abort_if(!$conversation->participants->contains(auth()->id()), 403);
        $messages = $this->conversationRepository->getMessages($conversation);

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
}