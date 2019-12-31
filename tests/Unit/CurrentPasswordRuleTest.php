<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Rules\CurrentPassword;
use App\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CurrentPasswordRuleTest extends TestCase
{
    /** @test */
    public function it_checks_if_current_password_is_correct()
    {
        $password = $this->getDefaultPassword();
        $user = factory(User::class)->create([
            'password' => Hash::make($password),
        ]);
        $rule = ['password' => [new CurrentPassword($user->email)]];

        $this->assertTrue(validator(compact('password'), $rule)->passes());
    }

    /** @test */
    public function it_checks_if_current_password_is_wrong()
    {
        $user = factory(User::class)->create([
            'password' => Hash::make($this->getDefaultPassword()),
        ]);

        $rule = ['password' => [new CurrentPassword($user->email)]];
        $this->assertFalse(validator(['password' => 'wrongPassword'], $rule)->passes());
    }
}
