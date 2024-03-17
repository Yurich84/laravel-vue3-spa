<?php

namespace App\Modules\Auth\Controllers;

use App\Modules\Core\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class CurrentUserController extends Controller
{
    public function __invoke(): JsonResponse
    {
        return response()->json([
            'data' => auth()->user(),
        ]);
    }
}
