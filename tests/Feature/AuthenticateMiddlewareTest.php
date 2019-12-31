<?php

declare(strict_types=1);

namespace Tests\Feature;

use Illuminate\Support\Facades\Lang;
use Tests\TestCase;

class AuthenticateMiddlewareTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        $router = app('router');
        $router->post('/protected', ['middleware' => 'auth', fn (): string => 'Welcome!']);
    }

    /** @test */
    public function it_aborts_request_if_not_signed_in()
    {
        $this->post('/protected')
            ->seeStatusCode(401)
            ->seeJsonStructure(['message'])
            ->seeJsonContains(['message' => Lang::get('auth.failed')]);
    }

    /** @test */
    public function it_allows_request_to_protected_route_if_signed_in()
    {
        $this->signIn();

        $this->post('/protected')->seeStatusCode(200);
    }
}
