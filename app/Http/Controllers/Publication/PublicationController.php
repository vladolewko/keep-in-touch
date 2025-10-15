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

class PublicationController extends Controller
{
    public function __construct(
        private readonly IPublicationServiceInterface $publicationService,
        private readonly IUserPublicationLikeServiceInterface $likeService,
    ) {}

    /**
     * Display list of publications
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
     * Display subscriptions publications
     */
    public function subscriptions(): View
    {
        return view('publications/subscriptionsPublicationsList');
    }

    /**
     * Create new publication
     */
    public function create(CreatePublicationRequest $request): RedirectResponse
    {
        try {
            $validated = $request->validated();
            $validated['user_id'] = Auth::id();

            $publication = $this->publicationService->create($validated);

            if (isset($validated['image'])) {
                $publication->addMedia($validated['image'])
                    ->toMediaCollection('publication_images');
            }

            return back()->with('success', 'Publication created successfully');
        } catch (\Exception $e) {
            Log::error('Create Publication Error: ' . $e->getMessage());
            return back()->with('error', 'Error creating publication')->withInput();
        }
    }

    /**
     * Show edit form
     */
    public function edit(int $id): View
    {
        $publication = $this->publicationService->find($id);

        if (!$publication) {
            abort(404, 'Publication not found');
        }

        // Check if user owns the publication
        if ($publication->user_id !== Auth::id()) {
            abort(403, 'Unauthorized action');
        }

        return view('publications/edit', compact('publication'));
    }

    /**
     * Update publication
     */
    public function update(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'publication_id' => 'required|exists:publications,id',
                'title' => 'required|string|max:255',
                'description' => 'nullable|string|max:1000',
                'image' => 'nullable|file|image|max:10240', // 10MB max
                'remove_image' => 'nullable|boolean'
            ]);

            $publication = Publication::findOrFail($validated['publication_id']);

            // Check ownership
            if ($publication->user_id !== Auth::id()) {
                return back()->with('error', 'Unauthorized action');
            }

            // Handle image removal
            if ($request->has('remove_image') && $request->boolean('remove_image')) {
                $publication->clearMediaCollection('publication_images');
            }

            // Update publication data
            $this->publicationService->update($validated['publication_id'], [
                'title' => $validated['title'],
                'description' => $validated['description'] ?? $publication->description,
            ]);

            // Add new image if provided
            if ($request->hasFile('image')) {
                $publication->clearMediaCollection('publication_images');
                $publication->addMedia($request->file('image'))
                    ->toMediaCollection('publication_images');
            }

            return redirect()->route('profile.myProfile')
                ->with('success', 'Publication updated successfully');
        } catch (\Exception $e) {
            Log::error('Update Publication Error: ' . $e->getMessage());
            return back()->with('error', 'Error updating publication')->withInput();
        }
    }

    /**
     * Toggle like on publication
     */
    public function like(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'publication_id' => 'required|exists:publications,id'
            ]);

            if (!auth()->check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'You must be logged in to like a publication.'
                ], 401);
            }

            $result = $this->likeService->toggleLike(
                $validated['publication_id'],
                Auth::id()
            );

            return response()->json($result);
        } catch (\Exception $e) {
            Log::error('Like Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred while processing your request.'
            ], 500);
        }
    }

    /**
     * Check if user liked publication
     */
    public function checkLikeStatus(int $publicationId): JsonResponse
    {
        try {
            if (!auth()->check()) {
                return response()->json([
                    'success' => true,
                    'liked' => false
                ]);
            }

            $liked = $this->likeService->hasUserLiked($publicationId, Auth::id());

            return response()->json([
                'success' => true,
                'liked' => $liked,
                'likes_count' => $this->likeService->getLikesCount($publicationId)
            ]);
        } catch (\Exception $e) {
            Log::error('Check Like Status Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred.'
            ], 500);
        }
    }

    /**
     * Get users who liked publication
     */
    public function getLikedUsers(int $publicationId): JsonResponse
    {
        try {
            $users = $this->likeService->getUsersWhoLiked($publicationId);

            return response()->json([
                'success' => true,
                'users' => $users,
                'count' => count($users)
            ]);
        } catch (\Exception $e) {
            Log::error('Get Liked Users Error: ' . $e->getMessage());

            return response()->json([
                'success' => false,
                'message' => 'An error occurred.'
            ], 500);
        }
    }

    /**
     * Repost publication (placeholder - implement similar to likes)
     */
    public function toggleRepost(Request $request): JsonResponse
    {
        $data = $request->validate(['publication_id' => 'required|exists:publications,id']);

        try {
            $result = $this->publicationService->toggleRepost($data['publication_id'], Auth::id());

            return response()->json(['success' => true] + $result);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'An error occurred.'
            ], 500);
        }
    }

    /**
     * Toggle publication status (soft delete/restore)
     */
    public function toggleStatus(Request $request): RedirectResponse
    {
        try {
            $validated = $request->validate([
                'publication_id' => 'required|exists:publications,id'
            ]);

            $publication = $this->publicationService->find($validated['publication_id'], true);

            // Check ownership
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
     * Delete publication permanently
     */
    public function destroy(int $publicationId): RedirectResponse
    {
        try {
            $publication = $this->publicationService->find($publicationId, true);

            // Check ownership
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