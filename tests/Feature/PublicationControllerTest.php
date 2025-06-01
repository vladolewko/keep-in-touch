<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PublicationControllerTest extends TestCase
{
    #[Test]
   public function show_publications_by_user()
   {
       $user = User::factory()->create();
       $this->actingAs($user);

       $userAuthor = User::factory()->create();
       $publication = Publication::factory()->create([
           'user_id' => $userAuthor->id,
           'title' => 'Test Publication',
       ]);
//       dd($publication);

       $response = $this->get(route('user.publications', ['id' => $userAuthor->id]));
       $response->assertStatus(200);
       $response->assertJsonFragment([
           'data' => [
               [
                   'id' => $publication->id,
                   'title' => $publication->title,
                   'user' => [
                       'id' => $userAuthor->id,
                       'nickname' => $userAuthor->nickname,
                   ],
               ],
           ],
       ]);
   }
}
