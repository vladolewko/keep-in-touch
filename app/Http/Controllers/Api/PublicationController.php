<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PublicationResource;
use App\Models\Publication;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;

/**
 * @OA\Info(
 *      title="My Laravel API",
 *      version="1.0.0",
 *      description="API Documentation for Publications"
 *  )
 * @OA\Server(
 *      url="http://127.0.0.1:8000",
 *      description="Local Development Server"
 *  )
 * @OA\SecurityScheme(
 *      securityScheme="bearerAuth",
 *      type="http",
 *      scheme="bearer",
 *      bearerFormat=""
 *  )
 *
 * @OA\Tag(
 *     name="Publications",
 *     description="Publication Api"
 * )
 */
class PublicationController extends Controller
{
    /**
     * @OA\Get(
     *     path="/api/v1/publications",
     *     tags={"Publications"},
     *     summary="Get all publications",
     *     @OA\Response(
     *         response=200,
     *         description="List of publications",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PublicationResource")
     *         )
     *     )
     * )
     */
    public function index()
    {
        $publications = Publication::all();
        return PublicationResource::collection($publications);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/users/{userId}/publications",
     *     tags={"Publications"},
     *     summary="Get publications by user",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="List of user publications",
     *         @OA\JsonContent(
     *             type="array",
     *             @OA\Items(ref="#/components/schemas/PublicationResource")
     *         )
     *     )
     * )
     */
    public function getListByUser($userId)
    {
        $publications = Publication::where('user_id', $userId)->get();
        return PublicationResource::collection($publications);
    }

    /**
     * @OA\Post(
     *     path="/api/v1/users/{userId}/publications",
     *     tags={"Publications"},
     *     summary="Create new publication",
     *     @OA\Parameter(
     *         name="userId",
     *         in="path",
     *         required=true,
     *         description="User ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             @OA\Property(property="title", type="string", maxLength=255, example="My Publication Title"),
     *             @OA\Property(property="description", type="string", nullable=true, example="Publication description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=201,
     *         description="Publication created successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PublicationResource")
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function store(Request $request, string $userId)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $publication = Publication::create(array_merge($validated, ['user_id' => $userId]));

        return new PublicationResource($publication);
    }

    /**
     * @OA\Get(
     *     path="/api/v1/publications/{id}",
     *     tags={"Publications"},
     *     summary="Get publication by ID",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Publication ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Publication details",
     *         @OA\JsonContent(ref="#/components/schemas/PublicationResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Publication not found"
     *     )
     * )
     */
    public function show(string $id)
    {
        $publication = Publication::find($id);
        if (!$publication) {
            return response()->json(['message' => 'Publication not found'], 404);
        }
        return new PublicationResource($publication);
    }

    /**
     * @OA\Put(
     *     path="/api/v1/publications/{publicationId}",
     *     tags={"Publications"},
     *     summary="Update publication",
     *     @OA\Parameter(
     *         name="publicationId",
     *         in="path",
     *         required=true,
     *         description="Publication ID",
     *         @OA\Schema(type="integer")
     *     ),
     *     @OA\RequestBody(
     *         required=true,
     *         @OA\JsonContent(
     *             required={"title"},
     *             @OA\Property(property="title", type="string", maxLength=255, example="Updated Publication Title"),
     *             @OA\Property(property="description", type="string", nullable=true, example="Updated description")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Publication updated successfully",
     *         @OA\JsonContent(ref="#/components/schemas/PublicationResource")
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Publication not found"
     *     ),
     *     @OA\Response(
     *         response=422,
     *         description="Validation error"
     *     )
     * )
     */
    public function update(int $publicationId, Request $request)
    {
        $publication = Publication::find($publicationId);
        if (!$publication) {
            return response()->json(['message' => 'Publication not found'], 404);
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $publication->update($validated);

        return new PublicationResource($publication);
    }

    /**
     * @OA\Delete(
     *     path="/api/v1/publications/{id}",
     *     tags={"Publications"},
     *     summary="Delete publication",
     *     @OA\Parameter(
     *         name="id",
     *         in="path",
     *         required=true,
     *         description="Publication ID",
     *         @OA\Schema(type="string")
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Publication deleted successfully",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Publication deleted successfully")
     *         )
     *     ),
     *     @OA\Response(
     *         response=404,
     *         description="Publication not found",
     *         @OA\JsonContent(
     *             @OA\Property(property="message", type="string", example="Publication not found")
     *         )
     *     )
     * )
     */
    public function destroy(string $id)
    {
        $publication = Publication::find($id);
        if (!$publication) {
            return response()->json(['message' => 'Publication not found'], 404);
        }
        $publication->delete();
        return response()->json(['message' => 'Publication deleted successfully']);
    }
}
