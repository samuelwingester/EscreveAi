<?php

namespace App\Http\Requests\Student;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            // User Class Data
            'secondary_email'   => ['sometimes', 'email', 'unique:users,email'],
            'name'              => ['sometimes', 'string', 'max:150'],
            'gender'            => ['sometimes', 'string', new Enum( Gender::class )],
            'birth_date'        => ['sometimes', Rule::date()->before(today()->subYears(4))],
            //

            // Student Class Data
            'class_id'      => ['sometimes', 'exists:classes,id'],
            'writing_level' => ['sometimes', 'string', new Enum( WritingLevel::class )],
            'observations'  => ['sometimes', 'string']
            //
        ];
    }
}
