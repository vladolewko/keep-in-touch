<?php 

namespace App\Services\Interfaces;

interface PublicationServiceInterface
{
    public function createPublication(array $data): array;

    public function getPublication(int $id): array;

    public function updatePublication(int $id, array $data): array;

    public function deletePublication(int $id): array;
}
