<?php

declare(strict_types=1);

namespace Tests\Feature;

use Tests\TestCase;

class AuthUserControllerTest extends TestCase
{
    /** @test */
    public function it_has_the_authenticated_user()
    {
        $user = $this->signIn();

        $this->post(route('auth.user'))
            ->seeStatusCode(200)
            ->seeJsonStructure(['message', 'data'])
            ->seeJsonContains(['data' => $user->toArray()]);
    }
}
