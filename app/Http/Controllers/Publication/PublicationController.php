<?php

namespace App\Http\Controllers\Publication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Publication\CreatePublicationRequest;
use App\Models\Publication;
use App\Models\PublicationComment;
use App\Models\User;
use App\Models\UserCommentLike;
use App\Models\UserPublicationLike;
use App\Models\UserPublicationRepost;
use Illuminate\Foundation\Application;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Http\Services\GoogleTagManagerService;

class PublicationController extends Controller
{
    public function publications(Request $request): View
    {
        $parameter = $request->get('parameter');
        $filter = $request->get('filter');
        $search = $request->get('search');

        $publications = Publication::getPublicationsList($parameter, $filter, $search);

        return view('publications/publicationsList', compact('publications'));
    }

    public function subscriptions(): View
    {
        return view('publications/subscriptionsPublicationsList');
    }

    public function create(CreatePublicationRequest $request): RedirectResponse
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $publication = Publication::create($data);

        if (isset($data['image'])) {
            $publication->addMedia($data['image'])
                ->toMediaCollection('publication_images');
        }

        return back();
    }

    public function edit(int $id): View
    {
        $publication = Publication::findById($id);
        return view('publications/edit', compact('publication'));
    }

    public function update(Request $request)
    {
        $data = $request->validate([
            'publication_id' => 'required|exists:publications,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|file|image'
        ]);

        $publication = Publication::findOrFail($data['publication_id']);

        if ($request->has('remove_image')) {
            $publication->clearMediaCollection('publication_images');
        } else {
            $publication->title = $data['title'];
            $publication->description = $data['description'] ?? $publication->description;
            $publication->save();

            if ($request->hasFile('image')) {
                $publication->addMedia($request->file('image'))
                    ->toMediaCollection('publication_images');
            }
        }

        return redirect('profile/myProfile');
    }

    public function like(Request $request): JsonResponse
    {
        // Validate the request
        $publication_id = $request->validate([
            'publication_id' => 'required|exists:publications,id'
        ])['publication_id'];

        return UserPublicationLike::likePublication($publication_id);
    }

    public function repost(Request $request): JsonResponse
    {
        // Validate the request
        $publication_id = $request->validate([
            'publication_id' => 'required|exists:publications,id'
        ])['publication_id'];


        return UserPublicationRepost::repostPublication($publication_id);
    }

    public function hide(Request $request): RedirectResponse
    {
        $publication_id = $request->validate([
            'publication_id' => 'required|exists:publications,id'
        ])['publication_id'];

        Publication::togglePublication($publication_id);

        return back();
    }

    public function destroy(int $publication_id): RedirectResponse
    {
        Publication::destroy($publication_id);

        return back();
    }

}
