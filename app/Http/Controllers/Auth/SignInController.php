<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Rules\CurrentPassword;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Laravel\Lumen\Routing\Controller;

class SignInController extends Controller
{
    /**
     * Handle the request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users',
            'password' => ['required', new CurrentPassword($request->input('email'))],
        ]);

        $token = Auth::attempt($request->only(['email', 'password']));

        if (!$token) {
            return response()->json([
                'error' => Lang::get('auth.failed'),
            ], 401);
        }

        Auth::user()->signIn();

        return response()->json([
            'message' => Lang::get('auth.signed_in'),
            'data' => $token,
        ]);
    }
}
