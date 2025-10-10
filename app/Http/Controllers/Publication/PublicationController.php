<?php

namespace App\Http\Controllers\Publication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Publication\CreatePublicationRequest;
use App\Models\Publication;
use App\Models\UserPublicationLike;
use App\Models\UserPublicationRepost;
use App\Services\Interfaces\IPublicationServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

/**
 *
 */
class PublicationController extends Controller
{
    /**
     * @param IPublicationServiceInterface $publicationService
     */
    public function __construct(
        private readonly IPublicationServiceInterface $publicationService,
    ) {}

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

        return view('publications/publicationsList', compact('publications'));
    }

    /**
     * @return View
     */
    public function subscriptions(): View
    {
        return view('publications/subscriptionsPublicationsList');
    }

    /**
     * @param CreatePublicationRequest $request
     * @return RedirectResponse
     */
    public function create(CreatePublicationRequest $request): RedirectResponse
    {

        $validated = $request->validated();
        $validated['user_id'] = Auth::user()->getId();

        $publication = $this->publicationService->create($validated);

        if (isset($validated['image'])) {
            $publication->addMedia($validated['image'])
                ->toMediaCollection('publication_images');
        }

        return back();
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $publication = $this->publicationService->find($id);
        return view('publications/edit', compact('publication'));
    }

    /**
     * @param Request $request
     * @return \Illuminate\Foundation\Application|RedirectResponse|\Illuminate\Routing\Redirector|object
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileDoesNotExist
     * @throws \Spatie\MediaLibrary\MediaCollections\Exceptions\FileIsTooBig
     */
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

    /**
     * @param Request $request
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
     * @param Request $request
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
     * @param Request $request
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
     * @param int $publication_id
     * @return RedirectResponse
     */
    public function destroy(int $publication_id): RedirectResponse
    {
        Publication::destroy($publication_id);

        return back();
    }

}
