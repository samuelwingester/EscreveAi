<?php

namespace App\Http\Controllers;

use App\Services\Attachment\FindAttachmentService;
use App\Services\Attachment\DeleteAttachmentService;
use App\Models\Attachment;
use App\Models\User;

use Illuminate\Auth\Access\Response;
use Illuminate\Http\Request;

class FileAttachmentController extends Controller
{
    public function __construct(
        private DeleteAttachmentService $delete,
        private FindAttachmentService $find
    ) {}

    public function delete( Attachment $attachment, Request $request )
    {
        $this->checkAttachment( $attachment, $request->user() );

        $this->delete->execute( $attachment );

        return response()->noContent();
    }

    public function show( Attachment $attachment, Request $request ) : mixed
    {
        $this->checkAttachment( $attachment, $request->user() );

        return $this->find->upload( $attachment );
    }

    public function download( Attachment $attachment, Request $request )
    {
        if ( $this->checkAttachment( $attachment, $request->user() ) )
            return Response::denyWithStatus( 404 );

        return $this->find->download( $attachment );
    }

    private function checkAttachment( Attachment $attachment, User $user ) : void
    {
        if ( $user->id != $attachment->user_id || $attachment->storage_type == 'url' )
            abort(404);
    }
}
