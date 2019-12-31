<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class AuthSignOutControllerTest extends TestCase
{
    /** @test */
    public function it_can_sign_out_a_user()
    {
        $user = $this->signIn();

        $this->post(route('auth.signout'))
            ->seeStatusCode(200)
            ->seeJsonStructure(['message', 'data'])
            ->seeJsonContains([
                'message' => Lang::get('auth.signed_out'),
            ]);

        $this->seeInDatabase('users', [
            'email' => $user->email,
            'signed_in_at' => null,
        ]);
    }
}
