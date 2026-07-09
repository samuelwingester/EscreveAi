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

class StoreStudentRequest extends FormRequest
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
        // Required fields normalization
        $normalization = [
            'email' => Str::lower( Str::trim( $this->email ) ),
            'name'  => Str::ucwords( Str::squish( $this->name ) ),
        ];

        // Optional fields normalization
        if ( $this->filled( 'gender' ) ) 
            $normalization['gender'] = Str::lower( Str::squish( $this->gender ) );

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
            // User Class Data
            'email'         => ['required', 'email', 'unique:users,email'],
            'password'      => ['required', 'confirmed', Password::min(8)],
            'name'          => ['required', 'string', 'max:150'],
            'gender'        => ['nullable', 'string', new Enum( Gender::class )],
            'birth_date'    => ['required', Rule::date()->before(today()->subYears(4))],
            //

            // Student Class Data
            'class_id'      => ['required', 'integer', 'exists:classes,id'],
            'writing_level' => ['nullable', 'string', new Enum( WritingLevel::class )],
            'observations'  => ['nullable', 'string']
            //
        ];
    }
}
