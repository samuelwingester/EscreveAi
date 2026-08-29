<?php

namespace App\Http\Requests\Classroom;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

use App\Enums\Shift;

class UpdateClassroomRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    protected function prepareForValidation(): void
    {
        // Required fields normalization
        $normalization = [];

        // optional field normalization
        if ( $this->filled( 'name' ) )
            $normalization['name'] = Str::ucwords( Str::squish( $this->name ) );

        if ( $this->filled( 'shift' ) )
            $normalization['shift'] = Str::squish( $this->shift );

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
            'active'    => ['sometimes', 'nullable', 'boolean'],
            'shift'     => ['sometimes', 'nullable', 'string', new Enum( Shift::class )]
        ];
    }
}
