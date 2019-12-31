<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use App\Jobs\ProcessPasswordRequest;
use App\User;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Str;
use Laravel\Lumen\Routing\Controller;

class ForgotPasswordController extends Controller
{
    /**
     * Handle the request.
     */
    public function __invoke(Request $request): JsonResponse
    {
        $this->validate($request, [
            'email' => 'required|email|exists:users',
        ]);

        $user = User::where('email', $request->input('email'))->first();

        $this->storeResetToken($user);

        Queue::pushOn('emails', new ProcessPasswordRequest($user));

        return response()->json([
            'message' => Lang::get('auth.password_requested'),
            'data' => null,
        ]);
    }

    /**
     * Store the reset token for the user.
     */
    protected function storeResetToken(User $user): void
    {
        DB::table('password_resets')->insert([
            'email' => $user->email,
            'token' => Str::random(64),
            'created_at' => Carbon::now(),
        ]);
    }
}
