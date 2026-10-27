<?php

namespace App\Services\Attachment;

use Throwable;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

use App\Enums\StorageType;
use App\Models\User;

class StoreAttachmentService
{
	public function execute( Model $attachable, array $data )
	{
		try{
			return $attachable->attachments()->create([
				'storage_type' 	=> $data['storage_type'],
				'file_path' 	=> $data['file_path'],
				'user_id'		=> $data['user_id'],
				'disk_type' 	=> $data['disk_type'] ?? null,
				'file_mime' 	=> $data['file_mime'] ?? null,
				'file_name' 	=> $data['file_name'] ?? null,
			]);
		}
		catch( Throwable $e ){
			if ( $data['storage_type'] == StorageType::LOCAL )
				Storage::disk( $data['disk_type'] )->delete( $data['file_path'] );
			throw $e;
		}
	}
}
