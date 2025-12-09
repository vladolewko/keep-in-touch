<?php

namespace Tests\Feature\Abstract;

use App\Models\User;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class AActionTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    /** @var User*/
    protected User $user;

    /** @return void */
    protected function setUp(): void
    {
        parent::setUp();

        $this->user = User::factory()->create();

        $this->withoutMiddleware([
            VerifyCsrfToken::class,
            \Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Foundation\Http\Middleware\ValidateCsrfToken::class,
        ]);
    }
}