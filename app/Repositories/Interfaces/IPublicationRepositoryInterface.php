<?php

namespace App\Repositories\Interfaces;

use App\Models\Publication;
use Exception;
use Illuminate\Database\Query\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use LaravelIdea\Helper\App\Models\_IH_Publication_QB;

/**
 *
 */
interface IPublicationRepositoryInterface
{
    /**
     * @param bool $withTrashed
     * @return Collection
     */
    public function all(bool $withTrashed = false): Collection | null;

    /**
     * @param int  $id
     * @param bool $withTrashed
     * @return null|Model
     */
    public function find(int $id, bool $withTrashed = false): Model | null;

    /**
     * @param array $validated
     * @return Publication
     * @throws Exception
     */
    public function create(array $validated): Publication;

    /**
     * @param int   $publicationId
     * @param array $validated
     * @return bool
     * @throws Exception
     */
    public function update(int $publicationId, array $validated) : bool;

    /**
     * @param int  $publicationId
     * @param bool $isForce
     * @return null|bool
     * @throws Exception
     */
    public function delete(int $publicationId, bool $isForce = false): null|bool;


    /** @return  \Illuminate\Database\Eloquent\Builder | _IH_Publication_QB*/
    public function query(): \Illuminate\Database\Eloquent\Builder | _IH_Publication_QB;
}