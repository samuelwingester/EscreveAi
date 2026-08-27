<?php

namespace App\Http\Requests\Student;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

use App\Enums\Gender;
use App\Enums\WritingLevel;

class UpdateStudentRequest extends FormRequest
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
        $normalization = [];

        // Optional fields normalization
        /*
        if ( $this->filled( 'secondary_email' ) )
            $normalization['secondary_email'] = Str::lower( Str::trim( $this->secondary_email ) );
        */

        if ( $this->filled( 'name' ) )
            $normalization['name'] = Str::ucwords( Str::squish( $this->name ) );

        /*
        if ( $this->filled( 'gender' ) )
            $normalization['gender'] = Str::lower( Str::squish( $this->gender ) );
        */

        if ( $this->filled( 'writing_level' ) )
            $normalization['writing_level'] = Str::slug( Str::squish( $this->writing_level ), '_' );

        if ( $this->filled( 'observations' ) )
            $normalization['observations'] = Str::trim( $this->observations );

        $this->merge( $normalization );
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            /*
            // User Class Data
            'secondary_email'   => ['sometimes', 'nullable', 'email', 'unique:users,email'],
            'name'              => ['sometimes', 'string', 'max:150'],
            //
            */

            // Student Class Data
            'name'          => ['sometimes', 'string', 'max:150'],
            'class_id'      => ['sometimes', 'integer', 'exists:classes,id'],
            'writing_level' => ['sometimes', 'nullable', 'string', new Enum( WritingLevel::class )],
            'observations'  => ['sometimes', 'nullable', 'string'],
            'birth_date'    => ['sometimes', Rule::date()->before(today()->subYears(4))],
            'gender'        => ['sometimes', 'nullable', 'string', new Enum( Gender::class )],
            //
        ];
    }
}
