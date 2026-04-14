<?php

namespace App\Modules\Setting\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'old_password' => [
                'string',
                'required',
                function ($attribute, $value, $fail): void {
                    if ($value && ! Hash::check($value, auth()->user()->password)) {
                        $fail(__('passwords.password_not_matched', ['attribute' => $attribute]));
                    }
                },
            ],
            'password' => [
                'string',
                'required',
                function ($attribute, $value, $fail): void {
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
                function ($attribute, $value, $fail): void {
                    if ($value != $this->password) {
                        $fail(__('passwords.password_not_matched', ['attribute' => $attribute]));
                    }
                },
            ],
        ];
    }
}
