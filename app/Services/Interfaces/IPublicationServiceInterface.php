<?php

namespace App\Services\Interfaces;

use App\Models\Publication;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 *
 */
interface IPublicationServiceInterface
{
    public function all(array $parameters, bool $withTrashed = false): LengthAwarePaginator;
    public function find(int $id, bool $withTrashed = false): Model | null;
    public function create(array $validated): Publication;
    public function update(int $publicationId, array $validated) : null|bool;
    public function delete(int $publicationId, bool $isForce = false): null|bool;
    public function restore(int $publicationId): bool;
    public function toggleStatus(Publication $publication): void;
    public function toggleLike(int $publicationId, int $userId): array;
//    public function toggleRepost(int $publicationId, int $userId): bool;
}