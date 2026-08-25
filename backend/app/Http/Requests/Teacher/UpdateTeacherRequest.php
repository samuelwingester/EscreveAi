<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

use App\Enums\Gender;

class UpdateTeacherRequest extends FormRequest
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
        if ( $this->filled( 'secondary_email' ) ) 
            $normalization['secondary_email'] = Str::lower( Str::trim( $this->secondary_email ) );

        if ( $this->filled( 'name' ) ) 
            $normalization['name'] = Str::ucwords( Str::squish( $this->name ) );

        if ( $this->filled( 'gender' ) ) 
            $normalization['gender'] = Str::lower( Str::squish( $this->gender ) );

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
            'secondary_email'   => ['sometimes', 'nullable', 'email', 'unique:users,email'],
            'name'              => ['sometimes', 'string', 'max:150'],
            'gender'            => ['sometimes', 'nullable', 'string', new Enum( Gender::class )],
            //'birth_date'        => ['sometimes', Rule::date()->before(today()->subYears(4))],
            //
        ];
    }
}
