<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Laravel\Lumen\Routing\Controller;

class UserController extends Controller
{
    /**
     * Handle the request.
     */
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'message' => null,
            'data' => Auth::user(),
        ]);
    }
}
