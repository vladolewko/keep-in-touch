<?php

namespace App\Http\Controllers\Communication;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Services\NotificationService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class NotificationController extends Controller
{
    protected NotificationService $notificationService;

    public function __construct(NotificationService $notificationService)
    {
        $this->notificationService = $notificationService;
    }

    /** @return View */
    public function notifications(): View
    {
        $notifications = $this->notificationService->get(Auth::id());

        return view('profile/notifications', compact('notifications'));
    }

    /**
     * @param int $id
     * @return RedirectResponse
     */
    public function readNotification(int $id): RedirectResponse
    {
        $this->notificationService->markAsRead($id);
        return back();
    }

    /**
     * @return RedirectResponse
     */
    public function readAllNotifications(): RedirectResponse
    {
        $this->notificationService->markAllAsRead(Auth::id());
        return back();
    }

}
