<?php

namespace App\Http\Requests\Authentication;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Support\Str;

use App\Models\Enums\Gender;

class UpdateRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $normalization = [];

        if ( $this->filled( 'gender' ) )
            $normalization['gender'] = Str::lower( Str::squish( $this->gender ) );

        if ( $this->filled( 'name' ) )
            $normalization['name'] = Str::ucwords( Str::squish( $this->name ) );

        $this->merge( $normalization );
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'name'          => ['sometimes', 'string', 'max:150'],
            'gender'        => ['sometimes', 'string', new Enum( Gender::class )],
        ];
    }
}
