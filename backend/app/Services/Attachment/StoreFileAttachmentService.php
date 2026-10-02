<?php

namespace App\Services\Attachment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

use App\Models\Attachment;

use App\Services\Attachment\StoreAttachmentService;

use App\Enums\DiskType;
use App\Enums\StorageType;

class StoreFileAttachmentService
{
	public function __construct(
		private StoreAttachmentService $storeService
	){}

	public function execute( Model $attachable, UploadedFile $file, DiskType $disk = DiskType::PRIVATE) : Attachment
	{
		$path = Storage::disk( $disk )
				->putFile( $file->hashName('/'.$attachable::class.'/'.$attachable->id.'/') , $file );

		$data['disk_type'] = $disk;
		$data['storage_type'] = StorageType::LOCAL;
		$data['file_mime'] = $file->getMimeType();
		$data['file_name'] = $file->getClientOriginalName();
		$data['file_path'] = $path;

		return $this->storeService->execute( $attachable, $data );
	}
}