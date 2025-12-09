<?php

namespace App\Http\Controllers\Publication;

use App\Http\Controllers\Controller;
use App\Http\Requests\Publication\CreatePublicationRequest;
use App\Models\Publication;
use App\Services\Interfaces\IPublicationServiceInterface;
use App\Services\Interfaces\IUserPublicationLikeServiceInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\View\View;

/** Class PublicationController */
class PublicationController extends Controller
{
    /**
     * @param IPublicationServiceInterface         $publicationService
     * @param IUserPublicationLikeServiceInterface $likeService
     */
    public function __construct(
        private readonly IPublicationServiceInterface         $publicationService,
        private readonly IUserPublicationLikeServiceInterface $likeService,
    ) {}

    /**
     * @param Request $request
     * @return View
     */
    public function index(Request $request): View
    {
        $sorting = $request->get('parameter');
        $filter  = $request->get('filter');
        $search  = $request->get('search');

        $publications = $this->publicationService->all([
            'sort'   => $sorting,
            'filter' => $filter,
            'search' => $search,
        ]);

        return view('publications.index', compact('publications'));
    }

    /**
     * @param CreatePublicationRequest $request
     * @return RedirectResponse
     */
    public function create(CreatePublicationRequest $request): RedirectResponse
    {
        try {
            $validated            = $request->validated();
            $validated['user_id'] = Auth::id();

            $publication = $this->publicationService->create($validated);

            if (isset($validated['image'])) {
                $publication
                    ->addMedia($validated['image'])
                    ->toMediaCollection('publication_images');
            }

            return back()->with('success', 'Publication created successfully');
        } catch (\Exception $e) {
            Log::error('Create Publication Error: ' . $e->getMessage());
            return back()->with('error', 'Error creating publication')->withInput();
        }
    }

    /**
     * @param int $id
     * @return View
     */
    public function edit(int $id): View
    {
        $publication = $this->publicationService->find($id);

        if (!$publication) {
            abort(404, 'Publication not found');
        }

        if ($publication->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action');
        }

        return view('publications/edit', compact('publication'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'publication_id' => 'required|exists:publications,id',
                'title'          => 'required|string|max:255',
                'description'    => 'nullable|string|max:1000',
                'image'          => 'nullable|file|image|max:10240',
                'remove_image'   => 'nullable|boolean',
            ]);

            $publication = Publication::findOrFail($validated['publication_id']);

            if ($publication->user_id !== Auth::id()) {
                return back()->with('error', 'Unauthorized action');
            }

            if ($request->has('remove_image') && $request->boolean('remove_image')) {
                $publication->clearMediaCollection('publication_images');
            }

            $this->publicationService->update($validated['publication_id'], [
                'title'       => $validated['title'],
                'description' => $validated['description'] ?? $publication->description,
            ]);

            if ($request->hasFile('image')) {
                $publication->clearMediaCollection('publication_images');
                $publication
                    ->addMedia($request->file('image'))
                    ->toMediaCollection('publication_images');
            }

            return redirect()
                ->route('profile')
                ->with('success', 'Publication updated successfully');
        } catch (\Exception $e) {
            Log::error('Update Publication Error: ' . $e->getMessage());
            return back()->with('error', 'Error updating publication')->withInput();
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function toggleLike(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'publication_id' => 'required|exists:publications,id',
            ]);

            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to like a publication.',
                ], 401);
            }

            $result = $this->likeService->toggleLike(
                $validated['publication_id'],
                Auth::id(),
            );

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Like Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.',
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function toggleRepost(Request $request): JsonResponse
    {
        try {
            $data   = $request->validate(['publication_id' => 'required|exists:publications,id']);
            $result = $this->publicationService->toggleRepost($data['publication_id'], Auth::id());

            return response()->json(['success' => true] + $result);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred.',
            ], 500);
        }
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function toggleStatus(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate(['publication_id' => 'required|exists:publications,id']);

            $publication = $this->publicationService->find($validated['publication_id'], true);

            if ($publication && $publication->user_id !== Auth::id()) {
                return back()->with('error', 'Unauthorized action');
            }

            $this->publicationService->toggleStatus($publication);

            return back()->with('success', 'Publication status updated');
        } catch (\Exception $e) {
            Log::error('Toggle Status Error: ' . $e->getMessage());
            return back()->with('error', 'Error updating publication status');
        }
    }

    /**
     * @param int $publicationId
     * @return RedirectResponse
     */
    public function destroy(int $publicationId): RedirectResponse
    {
        try {
            $publication = $this->publicationService->find($publicationId, true);

            if ($publication && $publication->user_id !== Auth::id()) {
                return back()->with('error', 'Unauthorized action');
            }

            $this->publicationService->delete($publicationId, true);

            return back()->with('success', 'Publication deleted successfully');
        } catch (\Exception $e) {
            Log::error('Delete Publication Error: ' . $e->getMessage());
            return back()->with('error', 'Error deleting publication');
        }
    }
}