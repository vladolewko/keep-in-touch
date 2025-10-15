<?php

namespace App\Repositories;

use App\Models\PublicationComment;
use App\Models\UserCommentLike;
use App\Repositories\Interfaces\ICommentRepositoryInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/** Class CommentRepository */
class CommentRepository implements ICommentRepositoryInterface
{
    /**
     * @param int $id
     * @return null|PublicationComment
     */
    public function findById(int $id): ?PublicationComment
    {
        return PublicationComment::find($id);
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $comment = $this->findById($id);
        if ($comment) {
            return $comment->delete();
        }
        return false;
    }

    /**
     * @param string|null $parameter
     * @param string|null $search
     * @return LengthAwarePaginator
     */
    public function adminSearch(string $parameter = null, string $search = null): LengthAwarePaginator
    {
        $query = PublicationComment::with('user:id,nickname');

        if ($search) {
            $query
                ->where('comment', 'like', "%{$search}%")
                ->orWhereHas('user', function ($q) use ($search) {
                    $q->where('nickname', 'like', "%{$search}%");
                });
        }

        $query->orderBy('created_at', 'desc');

        return $query->paginate(10);
    }

    /**
     * @param int $commentId
     * @param int $userId
     * @return null|UserCommentLike
     */
    public function findLike(int $commentId, int $userId): ?UserCommentLike
    {
        return UserCommentLike::where('user_id', $userId)
            ->where('comment_id', $commentId)
            ->first();
    }

    /**
     * @param int $commentId
     * @param int $userId
     * @return UserCommentLike
     */
    public function createLike(int $commentId, int $userId): UserCommentLike
    {
        return UserCommentLike::create([
            'user_id'    => $userId,
            'comment_id' => $commentId,
        ]);
    }

    /**
     * @param UserCommentLike $like
     * @return bool
     */
    public function deleteLike(UserCommentLike $like): bool
    {
        return $like->delete();
    }

    /**
     * @param array $data
     * @return PublicationComment
     */
    public function create(array $data): PublicationComment
    {
        return PublicationComment::create($data);
    }
}