<?php

namespace App\Http\Requests\Activity;

/**
 * TO DO:
 * - Criar um Regra separada para anexos
 */

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Validator;
use Illuminate\Support\Str;

class StoreRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        // Required fields normalization
        $normalization = [
            'title'         => Str::ucwords( Str::squish( $this->title ) ),
            'description'   => Str::trim( $this->description )
        ];

        $this->merge( $normalization );
    }

    public function rules(): array
    {
        return [
            'title'         => ['required', 'string', 'max:100'],
            'description'   => ['required', 'string'],

            'attachments'   => ['nullable', 'array'],

            'attachments.*.url'     => ['nullable', 'url'],
            'attachments.*.file'    => ['nullable', 'file', File::types(['png', 'pdf', 'jpg', 'doc', 'docx'])->max(100 * 1024)]
        ];
    }

    public function after(): array
    {
        return [
            // Verifica se somente um dos campos de file e url foram preenchidos
            function ( Validator $validator ) {
                foreach( $this->attachments ?? [] as $i => $attachment ){

                    $hasUrl = !empty($attachment['url']);
                    $hasFile = !empty($attachment['file']);

                    if ( $hasUrl && $hasFile )
                        $validator->errors()->add( "attachments.$i", 'envie somente um arquivo ou link por anexo' );

                    else if ( !$hasUrl && !$hasFile )
                        $validator->errors()->add( "attachments.$i", 'envie algo no anexo, um arquivo ou link' );
                }
            }
        ];
    }
}
