<?php

namespace App\Modules\Setting\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'old_password' => [
                'string',
                'required',
                function ($attribute, $value, $fail) {
                    if ($value && ! Hash::check($value, auth()->user()->password)) {
                        $fail(__('passwords.password_not_matched', ['attribute' => $attribute]));
                    }
                },
            ],
            'password' => [
                'string',
                'required',
                function ($attribute, $value, $fail) {
                    if ($value && Hash::check($value, auth()->user()->password)) {
                        $fail(__('passwords.password_matches_old', ['attribute' => $attribute]));
                    }
                },
                Password::min(8),
                //                    ->mixedCase()
                //                    ->letters()
                //                    ->numbers()
                //                    ->symbols()
                //                    ->uncompromised(),
            ],
            'password_confirmation' => [
                'string',
                'required',
                function ($attribute, $value, $fail) {
                    if ($value != $this->password) {
                        $fail(__('passwords.password_not_matched', ['attribute' => $attribute]));
                    }
                },
            ],
        ];
    }
}
