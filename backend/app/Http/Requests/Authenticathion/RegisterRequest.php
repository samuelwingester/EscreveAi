<?php

namespace App\Http\Requests\Authenticathion;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Str;

use App\Models\Enums\Gender;

class RegisterRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        // Required fields normalization
        $normalization = [
            'email' => Str::lower( Str::trim( $this->email ) ),
            'name'  => Str::ucwords( Str::squish( $this->name ) ),
        ];

        // Optional fields normalization
        if ( $this->filled( 'gender' ) )
            $normalization['gender'] = Str::lower( Str::squish( $this->gender ) );

        $this->merge( $normalization );
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'email'         => ['required', 'email', 'unique:users,email'],
            'password'      => ['required', 'confirmed', Password::min(5)],
            'name'          => ['required', 'string', 'max:150'],
            'gender'        => ['nullable', 'string', new Enum( Gender::class )],
        ];
    }
}
