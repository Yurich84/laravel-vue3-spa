<?php

namespace App\Modules\Auth\Actions;

use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsController;

class GetCurrentUser
{
    use AsController;

    public function handle(): JsonResponse
    {
        return response()->json([
            'data' => auth()->user(),
        ]);
    }
}
