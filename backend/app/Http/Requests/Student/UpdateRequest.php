<?php

namespace App\Http\Requests\Student;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;
use Illuminate\Support\Str;

use App\Models\Enums\WritingLevel;
//use App\Models\Enums\Gender;

class UpdateRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $normalization = [];

        if ( $this->filled( 'name' ) )
            $normalization['name'] = Str::ucwords( Str::squish( $this->name ) );

        if ( $this->filled( 'gender' ) )
            $normalization['gender'] = Str::lower( Str::squish( $this->gender ) );

        if ( $this->filled( 'writing_level' ) )
            $normalization['writing_level'] = Str::slug( Str::squish( $this->writing_level ), '-' );

        if ( $this->filled( 'observations' ) )
            $normalization['observations'] = Str::trim( $this->observations );

        $this->merge( $normalization );
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'name'          => ['sometimes', 'string', 'max:150'],
            'writing_level' => ['sometimes', 'nullable', 'string', new Enum( WritingLevel::class )],
            'observations'  => ['sometimes', 'nullable', 'string'],
            'birth_date'    => ['sometimes', Rule::date()->before(today()->subYears(4))],
            /*'gender'        => ['sometimes', 'nullable', 'string', new Enum( Gender::class )]*/
        ];
    }
}
