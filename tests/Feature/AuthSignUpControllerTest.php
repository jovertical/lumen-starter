<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Jobs\ProcessSignUp;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class AuthSignUpControllerTest extends TestCase
{
    /** @test */
    public function it_can_sign_up_a_user()
    {
        $data = [
            'name' => $this->faker->name,
            'email' => $this->faker->email,
            'password' => $this->getDefaultPassword(),
            'password_confirmation' => $this->getDefaultPassword(),
        ];

        Queue::fake();

        $this->post(route('auth.signup'), $data)
            ->seeStatusCode(200)
            ->seeJsonStructure(['message', 'data'])
            ->seeJsonContains([
                'message' => Lang::get('auth.signed_up'),
            ]);

        Queue::assertPushed(ProcessSignUp::class);

        $this->seeInDatabase('users', [
            'email' => $data['email'],
        ]);
    }
}
