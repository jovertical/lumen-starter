<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Str;
use stdClass;
use Tests\TestCase;

class AuthResetPasswordControllerTest extends TestCase
{
    /** @test */
    public function it_resets_the_password()
    {
        $user = factory('App\User')->create();
        $passwordReset = $this->createData($user);
        $newPassword = $this->getDefaultPassword();

        $parameters = [
            'token' => $passwordReset->token,
        ];

        $data = [
            'password' => $newPassword,
            'password_confirmation' => $newPassword,
        ];

        $this->post(route('auth.password.reset', $parameters), $data)
            ->seeStatusCode(200)
            ->seeJsonStructure(['message', 'data'])
            ->seeJsonContains([
                'message' => Lang::get('auth.password_reset'),
            ]);

        $this->notSeeInDatabase('password_resets', [
            'email' => $user->email,
        ]);
    }

    /**
     * Create a dummy password reset data.
     */
    protected function createData(User $user): stdClass
    {
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => Str::random(64),
            'created_at' => Carbon::now(),
        ]);

        return DB::table('password_resets')
            ->where('email', $user->email)
            ->first();
    }
}
