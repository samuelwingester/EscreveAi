<?php

namespace App\Http\Requests\Record;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\File;
use Illuminate\Validation\Validator;

class UpdateRecordRequest extends FormRequest
{
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