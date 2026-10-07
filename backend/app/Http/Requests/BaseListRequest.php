<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\In;
use Illuminate\Validation\Rule;

abstract class BaseListRequest extends FormRequest
{
    /** @var array<string> */
    abstract public array $orderByFields { get; }

    /** @var array<string> */
    abstract public array $acceptedFields { get; }

    private function getOrderByRule() : In
    {
        return Rule::in( $this->orderByFields );
    }

    private function getFieldsRule() : In
    {
        return Rule::in( $this->acceptedFields );
    }

    public function prepareForValidation() : void
    {
        $this->merge([
            'limit'     => $this->query( 'limit', 20 ),
            'offset'    => $this->query( 'offset', 0 ),
            'order_by'  => $this->query( 'order_by', 'id' ),
            'direction' => $this->query( 'direction', 'asc' ),
            'fields'    => $this->fields ? explode( ',', $this->fields ) : [],
        ]);
    }

    /** @return array<string, ValidationRule|array<mixed>|string> */
    public function rules() : array
    {
        return [
            'limit'     => ['required', 'integer', 'min:10', 'max:200'],
            'offset'    => ['required', 'integer', 'min:0'],
            'order_by'  => ['required', 'string', $this->getOrderByRule()],
            'direction' => ['required', 'string', 'in:asc,desc'],
            'fields'    => ['array'],
            'fields.*'  => [$this->getFieldsRule()]
        ];
    }
}
