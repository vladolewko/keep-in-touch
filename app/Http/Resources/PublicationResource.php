<?php

namespace App\Http\Resources;

use App\Models\Publication;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use OpenApi\Annotations as OA;

/**
 * @OA\Schema(
 *     schema="PublicationResource",
 *     type="object",
 *     title="Publication Resource",
 *     description="Publication resource representation",
 *     @OA\Property(property="id", type="integer", example=1, description="Publication ID"),
 *     @OA\Property(property="title", type="string", example="My First Publication", description="Publication title"),
 *     @OA\Property(property="description", type="string", nullable=true, example="This is a publication description", description="Publication description"),
 *     @OA\Property(
 *         property="user",
 *         type="object",
 *         description="User who created the publication",
 *         @OA\Property(property="id", type="integer", example=1, description="User ID"),
 *         @OA\Property(property="nickname", type="string", example="john_doe", description="User nickname")
 *     )
 * )
 */
class PublicationResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        /** @var Publication $this */
        return [
            'id' => $this->id,
            'title' => $this->title,
            'description' => $this->description ?? null,
            'user' => [
                'id' => $this->user->id,
                'nickname' => $this->user->nickname,
            ],
        ];
    }
}
