<?php

namespace App\Modules\Auth\Controllers;

use App\Models\User;
use App\Modules\Core\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\ValidationException;

class VerifyEmailController extends Controller
{
    /**
     * Mark the user's email address as verified.
     *
     * @param  Request  $request
     * @param  User  $user
     * @return JsonResponse
     */
    public function verify(Request $request, User $user)
    {
        if (! URL::hasValidSignature($request)) {
            return response()->json([
                'status' => trans('verification.invalid'),
            ], 400);
        }

        if ($user->hasVerifiedEmail()) {
            return response()->json([
                'status' => trans('verification.already_verified'),
            ], 400);
        }

        $user->markEmailAsVerified();

        event(new Verified($user));

        return response()->json([
            'status' => trans('verification.verified'),
        ]);
    }

    /**
     * Resend the email verification notification.
     *
     * @param  Request  $request
     * @return JsonResponse
     *
     * @throws ValidationException
     */
    public function resend(Request $request)
    {
        $request->validate(['email' => 'required|email']);

        /** @var User $user */
        $user = User::where('email', $request->email)->first();

        if (is_null($user)) {
            throw ValidationException::withMessages([
                'email' => [trans('verification.user')],
            ]);
        }

        if ($user->hasVerifiedEmail()) {
            throw ValidationException::withMessages([
                'email' => [trans('verification.already_verified')],
            ]);
        }

        $user->sendEmailVerificationNotification();

        return response()->json(['status' => trans('verification.sent')]);
    }
}
