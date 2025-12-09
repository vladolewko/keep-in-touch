<?php

namespace App\Http\Controllers\Admin;

use App\Enums\NotificationTopicEnum;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\DatabaseNotification;
use App\Services\Interfaces\ICommentServiceInterface;
use App\Services\Interfaces\INotificationServiceInterface;
use App\Services\Interfaces\IPublicationServiceInterface;
use App\Services\Interfaces\IUserServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/** Class AdminController */
class AdminController extends Controller
{
    /**
     * @param IPublicationServiceInterface  $publicationService
     * @param IUserServiceInterface         $userService
     * @param ICommentServiceInterface      $commentService
     * @param INotificationServiceInterface $notificationService
     */
    public function __construct(
        private readonly IPublicationServiceInterface  $publicationService,
        private readonly IUserServiceInterface         $userService,
        private readonly ICommentServiceInterface      $commentService,
    ) {}

    /** @return View */
    public function index(): View
    {
        return view('admin.index');
    }

    /**
     * @param Request $request
     * @return View
     */
    public function users(Request $request): View
    {
        $users = $this->userService->getAdminSortedUsers($request->all());
        return view('admin.users', compact('users'));
    }

    /**
     * @param Request $request
     * @return View
     */
    public function publications(Request $request): View
    {
        $publications = $this->publicationService->all($request->all());
        return view('admin.publications', compact('publications'));
    }

    /**
     * @param Request $request
     * @param int         $sent_to_id
     * @return RedirectResponse
     */
    public function sendMessage(Request $request, int $send_to_id): RedirectResponse
    {
        $validated = $request->validate([
            'topic'   => 'required|string',
            'message' => 'required|string|max:255',
        ]);

        $recipient = User::findOrFail($send_to_id);

        $topicEnum = NotificationTopicEnum::tryFrom($validated['topic']);

        if (!$topicEnum || $topicEnum->isSystemGenerated()) {
            return back()->withErrors(['topic' => 'Invalid or system-reserved topic selected.']);
        }

        $recipient->notify(new DatabaseNotification(
            topic: $topicEnum,
            message: $validated['message'],
            sender: auth()->user()
        ));

        return back()->with('message', 'Message sent successfully.');
    }

    /**
     * @param Request $request
     * @return View
     */
    public function comments(Request $request): View
    {
        $comments = $this->commentService->getAdminComments(
            $request->get('parameter'),
            $request->get('search'),
        );

        return view('admin.comments', compact('comments'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroyComment($id): RedirectResponse
    {
        $this->commentService->deleteComment($id);
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }

    /**
     * @param $id
     * @return \Illuminate\Http\JsonResponse|RedirectResponse
     */
    public function blockUser($id)
    {
        $this->userService->toggleUserBlock($id);

        if (request()->wantsJson()) {
            $user = User::withTrashed()->find($id);
            $isBlocked = $user->deleted_at !== null;

            return response()->json([
                'success' => true,
                'is_blocked' => $isBlocked,
                'message' => $isBlocked ? 'User blocked successfully.' : 'User restored successfully.',
            ]);
        }
        return redirect()->back()->with('success', 'User status updated successfully.');
    }

    /**
     * @param $userId
     * @return View
     */
    public function writeMessage($userId): View
    {
        $user = $this->userService->findUserById($userId);
        abort_if(!$user, 404);

        return view('admin.send-message', compact('user'));
    }
}