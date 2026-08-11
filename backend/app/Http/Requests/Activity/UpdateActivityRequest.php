<?php

namespace App\Http\Requests\Activity;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Validator;

class UpdateActivityRequest extends FormRequest
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
        if ( $this->filled( 'title' ) ) 
            $normalization['title'] = Str::ucwords( Str::squish( $this->title ) );

        if ( $this->filled( 'description' ) ) 
            $normalization['description'] = Str::trim( $this->description );
        
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
