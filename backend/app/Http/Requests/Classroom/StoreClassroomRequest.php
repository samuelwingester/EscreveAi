<?php

namespace App\Http\Requests\Classroom;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class StoreClassroomRequest extends FormRequest
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
        $this->merge([
            'name' => Str::ucwords( Str::squish( $this->name ) ),
        ]);
    }     

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // Possivelmente desnecessario
            'teacher_id' => ['required', 'integer', 'exists:teachers,id'],
            
            'name'       => ['required', 'string', 'max:100']
        ];
    }
}
