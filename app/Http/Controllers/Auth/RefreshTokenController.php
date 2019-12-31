<?php

declare(strict_types=1);

namespace App\Http\Controllers\Auth;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Lang;
use Laravel\Lumen\Routing\Controller;

class RefreshTokenController extends Controller
{
    /**
     * Handle the request.
     */
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'message' => Lang::get('auth.session_renewed'),
            'data' => Auth::refresh(),
        ]);
    }
}
