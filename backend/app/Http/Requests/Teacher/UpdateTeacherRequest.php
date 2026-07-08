<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

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
        ];
    }
}
