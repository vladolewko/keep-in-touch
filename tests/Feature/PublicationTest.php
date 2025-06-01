<?php

namespace Tests\Feature;

use App\Models\Publication;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class PublicationTest extends TestCase
{
    #[Test]
    public function is_displayed_publications_list_page()
    {
        $user = User::factory()->create();
        $this->actingAs($user);

        $userAuthor = User::factory()->create();
        $post1 = Publication::factory()->create([
            'user_id' => $userAuthor->id,
            'title' => 'Post Title 1',
            'description' => 'Post Description 1',
            'likes' => 10,
            'reposts' => 5,
        ]);
//        dd($post1);

//        dd(route('publications'));
        $response = $this->get(route('publications'));
        $response->assertStatus(200);
    }
}
