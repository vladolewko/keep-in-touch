<?php

namespace App\Services;

use App\Enums\NotificationTopicEnum;
use App\Models\PublicationComment;
use App\Notifications\DatabaseNotification;
use App\Repositories\Interfaces\ICommentRepositoryInterface;
use App\Repositories\Interfaces\IPublicationRepositoryInterface;
use App\Services\Interfaces\ICommentServiceInterface;
use Auth;
use Exception;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Throwable;

/** Class CommentService */
class CommentService implements ICommentServiceInterface
{
    /**
     * @param ICommentRepositoryInterface     $commentRepository
     * @param IPublicationRepositoryInterface $publicationRepository
     */
    public function __construct(
        private readonly ICommentRepositoryInterface $commentRepository,
        private readonly IPublicationRepositoryInterface $publicationRepository,
        ) {}

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
     * @throws Exception
     */
    public function createComment(array $data, int $userId): PublicationComment
    {
        $commenter   = Auth::user();
        $publication = $this->publicationRepository->find($data['publication_id']);

        if (!$publication) {
            throw new Exception('Publication not found.');
        }

        $comment = $this->commentRepository->create([
            'publication_id' => $data['publication_id'],
            'comment'        => $data['comment'],
            'user_id'        => $userId,
        ]);

        $postOwner = $publication->user;

        if ($postOwner && $commenter && $postOwner->id !== $commenter->id) {
            $postOwner->notify(
                new DatabaseNotification(
                    topic: NotificationTopicEnum::COMMENT,
                    sender: $commenter,
                    contextData: [
                        'item_type'  => 'publication',
                        'item_id'    => $data['publication_id'],
                        'post_title' => $publication->title ?? 'публікацію',
                        'comment_id' => $comment->id,
                    ],
                ),
            );
        }
        return $comment;
    }

    /**
     * @param int $commentId
     * @param int $userId
     * @return array
     * @throws Throwable
     */
    public function toggleLike(int $commentId, int $userId): array
    {
        $comment = $this->commentRepository->findById($commentId);
        if (!$comment) {
            throw new Exception('Comment not found.');
        }

        DB::beginTransaction();
        try {
            $liker        = auth()->user();
            $commentOwner = $comment->user;
            $existingLike = $this->commentRepository->findLike($commentId, $liker->id);

            $isLiked = false;

            if ($existingLike) {
                $this->commentRepository->deleteLike($existingLike);
                $comment->decrement('likes');
            } else {
                $this->commentRepository->createLike($commentId, $liker->id);
                $comment->increment('likes');
                $isLiked = true;

                if ($commentOwner->id !== $liker->id) {
                    $commentOwner->notify(
                        new DatabaseNotification(
                            topic      : NotificationTopicEnum::LIKE,
                            contextData: [
                                'item_type'  => 'comment',
                                'item_id'    => $commentId,
                                'post_title' => $comment->publication->title ?? 'коментар',
                            ],
                        ),
                    );
                }
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