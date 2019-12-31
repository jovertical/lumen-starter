<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Rules\StrongPassword;
use App\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Lang;
use Laravel\Lumen\Routing\Controller;

class ResetPasswordController extends Controller
{
    /**
     * Handle the request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this->validate($request, [
            'password' => ['required', 'confirmed', new StrongPassword()],
        ]);

        $passwordReset = DB::table('password_resets')
            ->where('token', $request->input('token'))
            ->first();

        if (! $passwordReset) {
            return response()->json([
                'message' => Lang::get('auth.reset_token_invalid'),
            ], 421);
        }

        $user = User::where('email', $passwordReset->email)->first();

        $this->update($user, $request->input('password'));
        $this->deletePasswordReset($user);

        return response()->json([
            'message' => Lang::get('auth.password_reset'),
            'data' => Auth::tokenById($user->id),
        ]);
    }

    /**
     * Update the user.
     */
    protected function update(User $user, string $password): bool
    {
        $user->password = Hash::make($password);

        return $user->update();
    }

    /**
     * Delete all existing password resets for the user.
     */
    protected function deletePasswordReset(User $user)
    {
        DB::table('password_resets')
            ->where('email', $user->email)
            ->delete();
    }
}
