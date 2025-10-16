<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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
        private readonly INotificationServiceInterface $notificationService,
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
     * @param         $sent_to_id
     * @return RedirectResponse
     */
    public function sendMessage(Request $request, $sent_to_id): RedirectResponse
    {
        $data = $request->validate([
            'topic'   => 'required|string|max:255',
            'message' => 'required|string|max:255',
        ]);

        $this->notificationService->sendMessage($data, auth()->id(), $sent_to_id);

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
     * @return RedirectResponse
     */
    public function destroyPublication($id): RedirectResponse
    {
        $this->publicationService->destroy($id);
        return redirect()->back()->with('success', 'Publication deleted successfully.');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function blockUser($id): RedirectResponse
    {
        $this->userService->toggleUserBlock($id);

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