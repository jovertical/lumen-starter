<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Rules\StrongPassword;
use Tests\TestCase;

class StrongPasswordRuleTest extends TestCase
{
    /** @test */
    public function a_password_is_strong()
    {
        $password = $this->getDefaultPassword();
        $rule = ['password' => [new StrongPassword()]];

        $this->assertTrue(validator(compact('password'), $rule)->passes());
    }

    /** @test */
    public function a_password_is_weak()
    {
        $rule = ['password' => [new StrongPassword()]];

        $this->assertFalse(validator(['password' => 'password'], $rule)->passes());
        $this->assertFalse(validator(['password' => 'Password'], $rule)->passes());
        $this->assertFalse(validator(['password' => 'Password123'], $rule)->passes());
    }
}
