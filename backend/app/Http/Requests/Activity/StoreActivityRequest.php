<?php

namespace App\Http\Requests\Activity;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Validator;

class StoreActivityRequest extends FormRequest
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
            'title'         => Str::ucwords( Str::squish( $this->title ) ),
            'description'   => Str::trim( $this->description )
        ];

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
            'class_id'      => ['required', 'integer', 'exists:classes,id'], //NT: provavelment desnecessario
            'title'         => ['required', 'string', 'max:100'],
            'description'   => ['required', 'string'],

            'attachments'   => ['nullable', 'array'],

            'attachments.*.url'     => ['nullable', 'url'],
            'attachments.*.file'    => ['nullable', 'file', File::types(['png', 'pdf', 'jpg'])]
        ];
    }

    public function after(): array
    {
        return [
            // Verifiva se somente um dos campos de file e url foram preenchidos
            function ( Validator $validator ) {
                foreach( $this->attachments ?? [] as $i => $attachment ){

                    $hasUrl = !empty($attachment['url']);
                    $hasFile = !empty($attachment['file']);

                    if ( $hasUrl && $hasFile )
                        $validator->errors()->add( "attachments.$i", 'envie somente um arquivo o link por anexo' );

                    else if ( !$hasUrl && !$hasFile )
                        $validator->errors()->add( "attachments.$i", 'envie algo no anexo um arquivo ou link' );
                }
            }
        ];
    }
}
