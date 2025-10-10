<?php

namespace App\Repositories;

use App\Models\Publication;
use App\Repositories\Interfaces\IPublicationRepositoryInterface;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use LaravelIdea\Helper\App\Models\_IH_Publication_QB;

/**
 *
 */
class PublicationRepository implements IPublicationRepositoryInterface
{
    /**
     * @param bool $withTrashed
     * @return Collection
     */
    public function all(bool $withTrashed = false): Collection
    {
        return $withTrashed ? Publication::withTrashed()->get() : Publication::all();
    }

    /**
     * @param int  $id
     * @param bool $withTrashed
     * @return Publication
     */
    public function find(int $id, bool $withTrashed = false): ?Publication
    {
        try {
            return $withTrashed ? Publication::withTrashed()->find($id) : Publication::find($id);
        } catch (Exception $e) {
            return null;
        }
    }

    /**
     * @param array $validated
     * @return Publication
     * @throws Exception
     */
    public function create(array $validated): Publication
    {
        try {
            $publication = Publication::create($validated);
        } catch (Exception $e) {
            throw new Exception('Error creating publication: ' . $e->getMessage());
        }
        return $publication;
    }

    /**
     * @param int   $publicationId
     * @param array $validated
     * @return null|bool
     * @throws Exception
     */
    public function update(int $publicationId, array $validated) : bool
    {
        try {
            return $this->find($publicationId, true)?->update($validated);
        } catch (Exception $e) {
            throw new Exception('Error updating publication: ' . $e->getMessage());
        }
    }

    /**
     * @param int  $publicationId
     * @param bool $isForce
     * @return bool
     * @throws Exception
     */
    public function delete(int $publicationId, bool $isForce = false): bool
    {
        try {
            /** @var Publication $publication */
            $publication = $this->find($publicationId, true);

            if (!$publication) {
                return false;
            }
            if ($isForce) {
                $publication->media()->delete();
                $publication->forceDelete();
            } else {
                $publication->delete();
            }

            return true;
        } catch (Exception $e) {
            throw new Exception('Error deleting publication: ' . $e->getMessage());
        }
    }

    /**
     * @return \Illuminate\Database\Eloquent\Builder|_IH_Publication_QB
     */
    public function query(): \Illuminate\Database\Eloquent\Builder | _IH_Publication_QB
    {
        return Publication::query();
    }

}