<?php
// app/Http/View/Composers/UnreadNotificationsComposer.php

namespace App\View\Composers;

use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Services\NotificationService;

class UnreadNotificationsComposer
{
    public function __construct(protected NotificationService $notificationService) {}

    public function compose(View $view): void
    {
        if (Auth::check()) {
            $unreadNotificationsCount = $this->notificationService->getUnreadCount(Auth::id());
            $view->with('unreadNotificationsCount', $unreadNotificationsCount);
        } else {
            $view->with('unreadNotificationsCount', 0);
        }
    }
}