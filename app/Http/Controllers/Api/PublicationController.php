<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\PublicationResource;
use App\Models\Publication;
use Illuminate\Http\Request;
use OpenApi\Annotations as OA;



class PublicationController extends Controller
{
   
    public function index()
    {
        $publications = Publication::all();
        return PublicationResource::collection($publications);
    }

    
    public function getListByUser($userId)
    {
        $publications = Publication::where('user_id', $userId)->get();
        return PublicationResource::collection($publications);
    }

    
public function store(Request $request, string $userId)
{
     $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
    ]);

    $publication = Publication::create(array_merge($validated, ['user_id' => $userId]));

    return new PublicationResource($publication);
}


public function show(string $id)
{
    $publication = Publication::find($id);
    return new PublicationResource($publication);
}


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