<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Publication;
use App\Models\PublicationComment;
use App\Models\User;
use App\Models\UserNotification;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminController extends Controller
{
    public function index()
    {
        return view('admin.dashboard');
    }

    public function users(Request $request)
    {
        $parameter = $request->get('parameter') ?? null;
        $search = $request->get('search') ?? null;
        $filter = $request->get('filter') ?? null;
        $users = User::adminSortUsers($parameter, $search, $filter);
        return view('admin.users', compact('users'));
    }

    public function publications(Request $request): View
    {
        $parameter = $request->get('parameter') ?? null;
        $filter = $request->get('filter') ?? null;
        $search = $request->get('search') ?? null;

        $publications = Publication::adminGetPublications($parameter, $filter, $search);

        return view('admin.publications', compact('publications'));
    }

    public function comments(Request $request): View
    {
        $parameter = $request->get('parameter') ?? null;
        $search = $request->get('search') ?? null;

        $comments = PublicationComment::adminGetComments($parameter, $search);
//        $comments = PublicationComment::paginate(10);

        return view('admin.comments', compact('comments'));
    }


    public function destroyComment($id)
    {
        $comment = PublicationComment::findOrFail($id);
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }

    public function destroyPublication($id)
    {
        $comment = Publication::findOrFail($id);
        $comment->delete();
        return redirect()->back()->with('success', 'Comment deleted successfully.');
    }


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

    public function writeMessage($id, $comment)
    {
        $user = User::findOrFail($id);
        return view('admin.send-message', compact('user',  'comment'));
    }

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
