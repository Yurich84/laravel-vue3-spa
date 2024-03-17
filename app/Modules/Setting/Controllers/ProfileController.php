<?php

namespace App\Modules\Setting\Controllers;

use App\Models\User;
use App\Modules\Core\Controllers\Controller;
use App\Modules\Setting\Requests\ChangePasswordRequest;
use App\Modules\Setting\Requests\ProfileRequest;
use Illuminate\Http\JsonResponse;

class ProfileController extends Controller
{
    /**
     * Update the user's profile information.
     *
     * @param  ProfileRequest  $profileRequest
     * @return JsonResponse
     */
    public function update(ProfileRequest $profileRequest)
    {
        /** @var User $user */
        $user = auth()->user();

        $user->fill($profileRequest->validated())->save();

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully updated',
        ]);
    }

    /**
     * Update the user's profile information.
     *
     * @param  ChangePasswordRequest  $request
     * @return JsonResponse
     */
    public function changePassword(ChangePasswordRequest $request)
    {
        /** @var User $user */
        $user = auth()->user();

        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'type' => self::RESPONSE_TYPE_SUCCESS,
            'message' => 'Successfully updated',
        ]);
    }
}
