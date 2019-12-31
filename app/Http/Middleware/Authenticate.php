<?php

declare(strict_types=1);

namespace App\Http\Middleware;

use Closure;
use Illuminate\Contracts\Auth\Factory as Auth;
use Illuminate\Http\Request;

class Authenticate
{
    /**
     * The authentication guard factory instance.
     */
    protected Auth $auth;

    /**
     * Create a new middleware instance.
     */
    public function __construct(Auth $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle an incoming request.
     */
    public function handle(
        Request $request,
        Closure $next,
        ?string $guard = null
    ) {
        if ($this->auth->guard($guard)->guest()) {
            return response(['message' => trans('auth.failed')], 401);
        }

        return $next($request);
    }
}
