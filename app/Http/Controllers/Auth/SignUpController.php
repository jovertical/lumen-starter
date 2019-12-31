<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Jobs\ProcessSignUp;
use App\Rules\StrongPassword;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Queue;
use Laravel\Lumen\Routing\Controller;

class SignUpController extends Controller
{
    /**
     * Handle the request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this->validate($request, [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'min:8', 'confirmed', new StrongPassword()],
        ]);

        $user = $this->storeUser($request);

        Queue::pushOn('emails', new ProcessSignUp($user));

        return response()->json([
            'message' => Lang::get('auth.signed_up'),
            'data' => Auth::tokenById($user->id),
        ]);
    }

    /**
     * Stores the user.
     */
    protected function storeUser(Request $request): User
    {
        return User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
        ]);
    }
}
