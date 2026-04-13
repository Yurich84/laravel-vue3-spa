<?php

namespace App\Modules\Setting\Actions;

use App\Enums\ResponseType;
use App\Models\User;
use App\Modules\Setting\Requests\ChangePasswordRequest;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsController;

class ChangePassword
{
    use AsController;

    public function handle(ChangePasswordRequest $request): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'type' => ResponseType::Success,
            'message' => __('messages.updated'),
        ]);
    }
}
