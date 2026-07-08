<?php

namespace App\Http\Requests\Teacher;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Validation\Rules\Enum;
use Illuminate\Validation\Rules\Password;
use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

use App\Enums\Gender;

class StoreTeacherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
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
            'password'      => ['required', 'confirmed', Password::min(5)],
            'name'          => ['required', 'string', 'max:150'],
            'gender'        => ['sometimes', 'nullable', 'string', new Enum( Gender::class )],
            'birth_date'    => ['required', Rule::date()->before(today()->subYears(4))],
            //
        ];
    }
}
