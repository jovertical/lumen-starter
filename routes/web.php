<?php

declare(strict_types=1);

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', fn (): string => env('APP_URL'));

$router->group(['namespace' => 'Auth', 'as' => 'auth', 'prefix' => 'auth'], static function () use ($router): void {
    $router->post('signup', ['uses' => 'SignUpController', 'as' => 'signup']);
    $router->post('signin', ['uses' => 'SignInController', 'as' => 'signin']);
    $router->post('refresh', ['uses' => 'RefreshTokenController', 'as' => 'refresh']);

    $router->group(['middleware' => 'auth'], static function () use ($router): void {
        $router->post('user', ['uses' => 'UserController', 'as' => 'user']);
        $router->post('signout', ['uses' => 'SignOutController', 'as' => 'signout']);
    });

    $router->group(['as' => 'password', 'prefix' => 'password'], static function () use ($router): void {
        $router->post('request', ['uses' => 'ForgotPasswordController', 'as' => 'request']);
        $router->post('reset', ['uses' => 'ResetPasswordController', 'as' => 'reset']);
    });

    $router->group(['as' => 'social', 'prefix' => '{provider}'], static function () use ($router): void {
        $router->get('/', ['uses' => 'SocialRedirectController', 'as' => 'redirect']);
        $router->get('/callback', ['uses' => 'SocialCallbackController', 'as' => 'callback']);
    });
});
