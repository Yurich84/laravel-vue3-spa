<?php

namespace App\Modules\Setting\Actions;

use App\Models\User;
use App\Modules\Setting\Requests\ProfileRequest;
use Illuminate\Http\JsonResponse;
use Lorisleiva\Actions\Concerns\AsController;

class UpdateProfile
{
    use AsController;

    public function handle(ProfileRequest $profileRequest): JsonResponse
    {
        /** @var User $user */
        $user = auth()->user();

        $user->fill($profileRequest->validated())->save();

        return response()->json([
            'type' => 'success',
            'message' => 'Successfully updated',
        ]);
    }
}
