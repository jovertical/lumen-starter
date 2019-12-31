<?php

declare(strict_types=1);

namespace Tests;

use App\User;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\TestCase as LumenTestCase;

abstract class TestCase extends LumenTestCase
{
    use DatabaseMigrations;

    /**
     * The Faker Generator instance.
     */
    protected \Faker\Generator $faker;

    /**
     * Creates the application.
     */
    public function createApplication()
    {
        $this->faker = FakerFactory::create();

        return require __DIR__ . '/../bootstrap/app.php';
    }

    /**
     * Setup the test environment.
     */
    public function setUp(): void
    {
        parent::setUp();

        Artisan::call('db:seed');
    }

    /**
     * Sign In the test user.
     */
    protected function signIn(?User $user = null): User
    {
        $user = $user ?: factory(\App\User::class)->create();

        $user->signIn();

        $this->actingAs($user);

        $token = Auth::tokenById($user->id);

        app('request')->headers->set('Authorization', "Bearer {$token}");

        return $user;
    }

    /**
     * Sign Up the test user.
     */
    protected function signUp(array $attributes): User
    {
        return User::create([
            'name' => $attributes['name'],
            'email' => $attributes['email'],
            'password' => Hash::make($attributes['password']),
        ]);
    }

    /**
     * Give a default test password.
     */
    protected function getDefaultPassword(): string
    {
        return 'Password123$';
    }
}
