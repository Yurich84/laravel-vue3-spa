<?php

namespace App\Modules\Auth\Actions;

use App\Modules\Auth\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsController;

class Login
{
    use AsController;

    public function handle(LoginRequest $request): JsonResponse
    {
        $user = $request->authenticate();

        $token = $user->createToken($request->device_name)->plainTextToken;

        return response()->json([
            'token' => $token,
        ])->header('Authorization', $token);
    }
}
