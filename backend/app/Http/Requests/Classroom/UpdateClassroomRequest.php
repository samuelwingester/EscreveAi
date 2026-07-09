<?php

namespace App\Http\Requests\Classroom;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateClassroomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    protected function prepareForValidation(): void
    {
        // Required fields normalization
        $normalization = [];

        // optional field normalization
        if ( $this->filled( 'name' ) ) 
            $normalization['name'] = Str::ucwords( Str::squish( $this->name ) );
        
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
            'name'      => ['sometimes', 'string', 'max:100'],
            'active'    => ['sometimes', 'nullable', 'boolean']
        ];
    }
}
