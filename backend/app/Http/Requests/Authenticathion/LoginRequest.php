<?php

namespace App\Http\Requests\Authenticathion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
{

    protected function prepareForValidation(): void
    {
        $this->merge([ 'email' => Str::lower( Str::trim( $this->email ) ) ]);
    } 

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'email'     => ['required', 'email'], 
            'password'  => ['required', Password::default()],
        ];
    }
}
