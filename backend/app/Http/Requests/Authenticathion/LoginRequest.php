<?php

namespace App\Http\Requests\Authenticathion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Str;

class LoginRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

     /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        $this->merge([ 'email' => Str::lower( Str::trim( $this->email ) ) ]);
    } 

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */ 
    public function rules(): array
    {
        return [
            'email'     => ['required', 'email'], 
            'password'  => ['required', Password::min(5)],
        ];
    }
}
