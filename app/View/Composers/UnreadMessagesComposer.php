<?php

namespace App\View\Composers;

use App\Repositories\ConversationRepository;
use Illuminate\View\View;

/** Class UnreadMessagesComposer */
class UnreadMessagesComposer
{
    /** @param ConversationRepository $conversationRepository */
    public function __construct(protected ConversationRepository $conversationRepository) {}

    /**
     * @param View $view
     * @return void
     */
    public function compose(View $view): void
    {
        if (auth()->check()) {
            $count = $this->conversationRepository->getTotalUnreadCount(auth()->user());
            $view->with('totalUnreadCount', $count);
        } else {
            $view->with('totalUnreadCount', 0);
        }
    }
}