<?php

namespace App\Http\Services;
class GoogleTagManagerService
{
    public function viewProfilePage($userId)
    {
        return [
            'event' => 'view_profile',
            'user_id' => auth()->user()->id,
            'profile_id' => $userId,
        ];
    }

    public function createPublication($publication)
    {
        return [
            'event' => 'create_publication',
            'user_id' => auth()->user()->id,
            'publication_id' => $publication->id,
            'title' => $publication->title,
            'timestamp' => $publication->created_at->format('Y-m-d H:i:s'),
        ];
    }
}
