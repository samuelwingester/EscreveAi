<?php

namespace App\Http\Requests\Classroom;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ListRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $this->merge([
            'limit'     => $this->query( 'limit', 20 ),
            'offset'    => $this->query( 'offset', 0 ),
            'order_by'  => $this->query( 'order_by', 'id' ),
            'direction' => $this->query( 'direction', 'asc' ),
            'columns'   => $this->columns ? explode( ',', $this->columns ) : [],
        ]);
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules(): array
    {
        return [
            'limit'     => ['required', 'integer', 'min:10', 'max:200'],
            'offset'    => ['required', 'integer', 'min:0'],
            'order_by'  => ['required', 'string', 'in:id,name,school,shift,created_at'],
            'direction' => ['required', 'string', 'in:asc,desc'],
            'columns'    => ['array'],
            'columns.*'  => ['in:id,name,school,shift,active']
        ];
    }
}
