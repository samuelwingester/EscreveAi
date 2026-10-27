<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class ChangePasswordRequest extends FormRequest
{
    public function rules(): array
    {
        return [
            'password'      => ['required'],
            'new_password'  => ['required', 'confirmed', Password::default()]
        ];
    }
}
