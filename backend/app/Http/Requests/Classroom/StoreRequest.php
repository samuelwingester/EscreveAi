<?php

namespace App\Http\Requests\Classroom;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

use App\Models\Enums\Shift;

class StoreRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $normalization = [ 'name' => Str::ucwords( Str::squish( $this->name ) ) ];

        if ( $this->filled( 'shift' ) )
            $normalization['shift'] = Str::squish( $this->shift );

        if ( $this->filled( 'school' ) )
            $normalization['school'] = Str::squish( $this->school );

        $this->merge( $normalization );
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'name'      => ['required', 'string', 'max:100'],
            'school'    => ['sometimes', 'string', 'max:100'],
            'shift'     => ['nullable', 'string', new Enum( Shift::class )]
        ];
    }
}
