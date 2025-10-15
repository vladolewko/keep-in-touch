<?php

namespace App\Services\Interfaces;

use App\Models\Publication;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/** Interface IPublicationServiceInterface */
interface IPublicationServiceInterface
{
    /**
     * @param array $parameters
     * @param bool  $withTrashed
     * @return LengthAwarePaginator
     */
    public function all(array $parameters, bool $withTrashed = false): LengthAwarePaginator;

    /**
     * @param int  $id
     * @param bool $withTrashed
     * @return null|Model
     */
    public function find(int $id, bool $withTrashed = false): Model | null;

    /**
     * @param array $validated
     * @return Publication
     */
    public function create(array $validated): Publication;

    /**
     * @param int   $publicationId
     * @param array $validated
     * @return null|bool
     */
    public function update(int $publicationId, array $validated) : null|bool;

    /**
     * @param int  $publicationId
     * @param bool $isForce
     * @return null|bool
     */
    public function delete(int $publicationId, bool $isForce = false): null|bool;

    /**
     * @param int $publicationId
     * @return bool
     */
    public function restore(int $publicationId): bool;

    /**
     * @param Publication $publication
     * @return void
     */
    public function toggleStatus(Publication $publication): void;

    /**
     * @param int $publicationId
     * @param int $userId
     * @return array
     */
    public function toggleLike(int $publicationId, int $userId): array;

    /**
     * @param int $id
     * @return bool
     */
    public function destroy(int $id): bool;

    /**
     * @param int $publicationId
     * @param int $userId
     * @return array
     */
    public function toggleRepost(int $publicationId, int $userId): array;
}