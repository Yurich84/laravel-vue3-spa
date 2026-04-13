<?php

namespace App\Modules\Auth\Actions;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Lorisleiva\Actions\Concerns\AsController;

class Logout
{
    use AsController;

    public function handle(Request $request): Response
    {
        $request->user()->currentAccessToken()->delete();
        Auth::guard('api')->forgetUser();
        app()->get('auth')->forgetGuards();

        return response()->noContent();
    }
}
