<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\PublicationComment;
use App\Models\User;
use App\Models\UserNotification;
use App\Services\Interfaces\IPublicationServiceInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 *
 */
class AdminController extends Controller
{
    /**
     * @param IPublicationServiceInterface $publicationService
     */
    public function __construct(
        private readonly IPublicationServiceInterface $publicationService,
    ) {}

    /**
     * @return View
     */
    public function index(): View
    {
        return view('admin.dashboard');
    }

    /**
     * @param Request $request
     * @return View
     */
    public function users(Request $request): View
    {
        $parameter = $request->get('parameter');
        $search = $request->get('search');
        $filter = $request->get('filter');
        $users = User::adminSortUsers($parameter, $search, $filter);
        return view('admin.users', compact('users'));
    }

    /**
     * @param Request $request
     * @return View
     */
    public function publications(Request $request): View
    {
        $sorting = $request->get('parameter');
        $filter = $request->get('filter');
        $search = $request->get('search');
        $publications = $this->publicationService->all([
            'sort' => $sorting,
            'filter' => $filter,
            'search' => $search,
        ]);
        return view('admin.publications', compact('publications'));
    }

    /**
     * @param Request $request
     * @return View
     */
    public function comments(Request $request): View
    {
        $parameter = $request->get('parameter');
        $search = $request->get('search');

        $comments = PublicationComment::adminGetComments($parameter, $search);
        //        $comments = PublicationComment::paginate(10);

        return view('admin.comments', compact('comments'));
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroyComment($id): RedirectResponse
    {
        $comment = PublicationComment::findOrFail($id);
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function destroyPublication($id): RedirectResponse
    {
        $comment = Publication::findOrFail($id);
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }

    /**
     * @param $id
     * @return RedirectResponse
     */
    public function blockUser($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        if ($user->trashed()) {
            $user->restore();

            $user->save();
        } else {
            $user->delete();
        }

        return redirect()->back()->with('success', 'User status updated successfully.');
    }

    /**
     * @param $userId
     * @return View
     */
    public function writeMessage($userId): View
    {
        $user = User::findOrFail($userId);
        return view('admin.send-message', compact('user'));
    }

    /**
     * @param Request $request
     * @param         $sended_to_id
     * @return RedirectResponse
     */
    public function sendMessage(Request $request, $sended_to_id)
    {
        $data = $request->validate([
            'topic' => 'required|string|max:255',
            'message' => 'required|string|max:255',
        ]);
        $data['sended_to_id'] = $sended_to_id;
        $data['user_id'] = auth()->user()->id;

        UserNotification::create($data);
        return back()->with('message', 'Message sent successfully.');
    }
}
