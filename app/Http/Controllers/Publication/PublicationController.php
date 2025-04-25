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

class PublicationController extends Controller
{
    /**
     * Display publications list page.
     *
     * @param Request $request for sorting
     *
     *  @return View
     */
    public function publications(Request $request): View
    {
        $parameter = $request->get('parameter') ?? null;
        $filter = $request->get('filter') ?? null;
        $search = $request->get('search') ?? null;

        $publications = Publication::getPublicationsList($parameter, $filter, $search);

        return view('publications/publicationsList', compact('publications'));
    }

    /**
     * Display publications list page.
     *
     * @return View
     */
    public function subscriptions(): View
    {
        return view('publications/subscriptionsPublications');
    }

    /**
     * Method for creating new publication.
     *
     * @param CreatePublicationRequest $request
     */
    public function create(CreatePublicationRequest $request): RedirectResponse
    {

        $data = $request->validated();
        $data['user_id'] = auth()->user()->id;

        $publication = Publication::create($data);

        $publication->addMedia($data['image'])
            ->toMediaCollection('publication_images');

        return back();
    }

    /**
     * Method for editing new publication.
     *
     * @param int $id
     *
     * @return View
     */
    public function edit($id): View
    {
        $publication = Publication::findOrFail($id);
        return view('publications/edit', compact('publication'));
    }

    /**
     * Method for updating publication.
     *
     * @param Request $request
     *
     * @return Application|RedirectResponse|Redirector|object
     */
    public function update(Request $request)
    {
        $data = $request->validate([
            'publication_id' => 'required|exists:publications,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:255',
            'image' => 'nullable|file|image'  // Add validation for image
        ]);

        // Find publication first, as we need it in both branches
        $publication = Publication::findOrFail($data['publication_id']);

        if ($request->has('remove_image')) {
            // Just remove the image, don't update other fields
            $publication->clearMediaCollection('publication_images');
        } else {
            // Update publication data
            $publication->title = $data['title'];
            $publication->description = $data['description'] ?? $publication->description;
            $publication->save();

            // Add new image if provided
            if ($request->hasFile('image')) {
                $publication->addMedia($request->file('image'))
                    ->toMediaCollection('publication_images');
            }
        }

        return redirect('profile/myProfile');
    }


    /**
     * Method for liking/unliking a publication.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function like(Request $request): JsonResponse
    {
        // Validate the request
        $publication_id = $request->validate([
            'publication_id' => 'required|exists:publications,id'
        ])['publication_id'];

        return UserPublicationLike::likePublication($publication_id);
    }

    /**
     * Method for repost/unrepost a publication.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function repost(Request $request): JsonResponse
    {
        // Validate the request
        $publication_id = $request->validate([
            'publication_id' => 'required|exists:publications,id'
        ])['publication_id'];


        return UserPublicationRepost::repostPublication($publication_id);
    }

    /**
     * Method for hiding/unhiding a publication.
     *
     * @param Request $request
     *
     * @return RedirectResponse
     */
    public function hide(Request $request): RedirectResponse
    {
        $publication_id = $request->validate([
            'publication_id' => 'required|exists:publications,id'
        ])['publication_id'];

        Publication::togglePublication($publication_id);

        return back();
    }


    /**
     * Method for deleting a publication.
     *
     * @param int $publication_id
     *
     * @return RedirectResponse
     */
    public function destroy(int $publication_id): RedirectResponse
    {
        Publication::destroy($publication_id);

        return back();
    }

}
