<?php

namespace App\Services\Interfaces;

use App\Models\PublicationComment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

/** Interface ICommentServiceInterface */
interface ICommentServiceInterface
{
    /**
     * @param string|null $parameter
     * @param string|null $search
     * @return LengthAwarePaginator
     */
    public function getAdminComments(string $parameter = null, string $search = null): LengthAwarePaginator;

    /**
     * @param int $id
     * @return bool
     */
    public function deleteComment(int $id): bool;

    /**
     * @param array $data
     * @param int   $userId
     * @return PublicationComment
     */
    public function createComment(array $data, int $userId): PublicationComment;

    /**
     * @param int $commentId
     * @param int $userId
     * @return array
     */
    public function toggleLike(int $commentId, int $userId): array;


}
