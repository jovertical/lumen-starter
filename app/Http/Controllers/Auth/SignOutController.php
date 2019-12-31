<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Laravel\Lumen\Routing\Controller;

class SignOutController extends Controller
{
    /**
     * Handle the request.
     */
    public function __invoke(): JsonResponse
    {
        Auth::user()->signOut();

        Auth::logout();

        return response()->json([
            'message' => Lang::get('auth.signed_out'),
            'data' => null,
        ]);
    }
}
