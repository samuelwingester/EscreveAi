<?php

namespace App\Services\Attachment;

use Throwable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

use App\Enums\StorageType;

class StoreAttachmentService
{
	public function execute( Model $attachable, array $data )
	{
		try{
			return DB::transaction( function () use ( $attachable, $data ) {
				return $attachable->attachments()->create([
					//required fields
					'storage_type' 	=> $data['storage_type'],
					'file_path' 	=> $data['file_path'],
					//

					// Nullable Fields
					'disk_type' 	=> $data['disk_type'] ?? null,
					'file_mime' 	=> $data['file_mime'] ?? null,
					'file_name' 	=> $data['file_name'] ?? null,
					//
				]);
			}, 2);
		}
		catch( Throwable $e ){
			if ( $data['storage_type'] == StorageType::LOCAL )
				Storage::disk( $data['disk_type'] )->delete( $data['file_path'] );
			throw $e;
		}
	}
}
