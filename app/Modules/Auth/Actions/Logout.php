<?php

namespace App\Modules\Auth\Actions;

use Illuminate\Contracts\Auth\Factory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Lorisleiva\Actions\Concerns\AsController;

class Logout
{
    use AsController;

    public function handle(Request $request): Response
    {
        $request->user()->currentAccessToken()->delete();
        app()->get(Factory::class)->forgetGuards();

        return response()->noContent();
    }
}
