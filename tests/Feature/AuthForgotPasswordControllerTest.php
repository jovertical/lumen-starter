<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Jobs\ProcessPasswordRequest;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Queue;
use Tests\TestCase;

class AuthForgotPasswordControllerTest extends TestCase
{
    /** @test */
    public function it_sends_the_reset_link_email()
    {
        $user = factory('App\User')->create();

        $data = [
            'email' => $user->email,
        ];

        Queue::fake();

        $this->post(route('auth.password.request'), $data)
            ->seeStatusCode(200)
            ->seeJsonStructure(['message', 'data'])
            ->seeJsonContains([
                'message' => Lang::get('auth.password_requested'),
            ]);

        Queue::assertPushed(ProcessPasswordRequest::class);

        $this->seeInDatabase('password_resets', [
            'email' => $user->email,
        ]);
    }
}
