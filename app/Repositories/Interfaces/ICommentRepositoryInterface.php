<?php

namespace App\Repositories\Interfaces;

use App\Models\PublicationComment;
use App\Models\UserCommentLike;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/** Interface ICommentRepositoryInterface */
interface ICommentRepositoryInterface
{
    /**
     * @param int $id
     * @return null|PublicationComment
     */
    public function findById(int $id): ?PublicationComment;

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool;

    /**
     * @param string|null $parameter
     * @param string|null $search
     * @return LengthAwarePaginator
     */
    public function adminSearch(string $parameter = null, string $search = null): LengthAwarePaginator;

    /**
     * @param int $commentId
     * @param int $userId
     * @return null|UserCommentLike
     */
    public function findLike(int $commentId, int $userId): ?UserCommentLike;

    /**
     * @param int $commentId
     * @param int $userId
     * @return UserCommentLike
     */
    public function createLike(int $commentId, int $userId): UserCommentLike;

    /**
     * @param UserCommentLike $like
     * @return bool
     */
    public function deleteLike(UserCommentLike $like): bool;

    /**
     * @param array $data
     * @return PublicationComment
     */
    public function create(array $data): PublicationComment;

}