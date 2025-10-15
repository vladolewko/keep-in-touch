<?php

namespace App\Services;

use App\Models\PublicationComment;
use App\Repositories\Interfaces\ICommentRepositoryInterface;
use App\Services\Interfaces\ICommentServiceInterface;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

/** Class CommentService */
class CommentService implements ICommentServiceInterface
{
    /**
     * @param ICommentRepositoryInterface $commentRepository
     */
    public function __construct(private readonly ICommentRepositoryInterface $commentRepository) {}

    /**
     * @param string|null $parameter
     * @param string|null $search
     * @return LengthAwarePaginator
     */
    public function getAdminComments(string $parameter = null, string $search = null): LengthAwarePaginator
    {
        return $this->commentRepository->adminSearch($parameter, $search);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function deleteComment(int $id): bool
    {
        return $this->commentRepository->delete($id);
    }

    /**
     * @param array $data
     * @param int   $userId
     * @return PublicationComment
     */
    public function createComment(array $data, int $userId): PublicationComment
    {
        return $this->commentRepository->create([
            'publication_id' => $data['publication_id'],
            'comment'        => $data['comment'],
            'user_id'        => $userId,
        ]);
    }

    /**
     * @param int $commentId
     * @param int $userId
     * @return array
     * @throws \Throwable
     */
    public function toggleLike(int $commentId, int $userId): array
    {
        $comment = $this->commentRepository->findById($commentId);
        if (!$comment) {
            throw new Exception('Comment not found.');
        }

        DB::beginTransaction();
        try {
            $existingLike = $this->commentRepository->findLike($commentId, $userId);

            $isLiked = false;

            if ($existingLike) {
                $this->commentRepository->deleteLike($existingLike);
                $comment->decrement('likes');
            } else {
                $this->commentRepository->createLike($commentId, $userId);
                $comment->increment('likes');
                $isLiked = true;
            }

            DB::commit();

            return [
                'liked'       => $isLiked,
                'likes_count' => $comment->fresh()->likes,
            ];
        } catch (Exception $e) {
            DB::rollBack();
            Log::error('Comment Like Error: ' . $e->getMessage());
            throw $e;
        }
    }
}