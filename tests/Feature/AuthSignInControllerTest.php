<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class AuthSignInControllerTest extends TestCase
{
    /** @test */
    public function it_can_sign_in_a_user()
    {
        $user = $this->signIn();
        $user->password = Hash::make($this->getDefaultPassword());
        $user->save();

        $data = [
            'email' => $user->email,
            'password' => $this->getDefaultPassword(),
        ];

        $this->post(route('auth.signin'), $data)
            ->seeStatusCode(200)
            ->seeJsonStructure(['message', 'data'])
            ->seeJsonContains([
                'message' => Lang::get('auth.signed_in'),
            ]);
    }
}
