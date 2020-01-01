<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class AuthRefreshTokenControllerTest extends TestCase
{
    /** @test */
    public function it_refreshes_the_token()
    {
        $user = $this->signIn();

        $data = Auth::tokenById($user->id);

        $this->post(route('auth.refresh'))
            ->seeStatusCode(200)
            ->seeJsonStructure(['message', 'data'])
            ->seeJsonDoesntContains(compact('data'))
            ->seeJsonContains([
                'message' => Lang::get('auth.session_renewed'),
            ]);
    }
}
