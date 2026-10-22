<?php

namespace App\Http\Requests\Activity;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Validator;
use Illuminate\Support\Str;

class UpdateRequest extends FormRequest
{
    protected function prepareForValidation(): void
    {
        $normalization = [];

        if ( $this->filled( 'title' ) )
            $normalization['title'] = Str::ucwords( Str::squish( $this->title ) );

        if ( $this->filled( 'description' ) )
            $normalization['description'] = Str::trim( $this->description );

        $this->merge( $normalization );
    }

    public function rules(): array
    {
        return [
            'title'         => ['sometimes', 'string', 'max:100'],
            'description'   => ['sometimes', 'string'],

            'attachments'   => ['sometimes', 'array'],

            'attachments.*.url'     => ['sometimes', 'url'],
            'attachments.*.file'    => ['sometimes', 'file', File::types(['png', 'pdf', 'jpg'])]
        ];
    }

    public function after(): array
    {
        return [
            // Verifica se somente um dos campos de file e url foram preenchidos
            // NOTA: Colocar essa validação em uma classe apropriada depois
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
