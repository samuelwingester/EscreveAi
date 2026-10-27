<?php

namespace App\Services\Attachment;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

use App\Services\Attachment\StoreAttachmentService;
use App\Enums\DiskType;
use App\Enums\StorageType;
use App\Models\Attachment;
use App\Models\User;

class StoreFileAttachmentService
{
	public function __construct(
		private StoreAttachmentService $store
	){}

	public function execute(
		User $user,
		Model $attachable,
		UploadedFile $file,
		DiskType $disk =
		DiskType::PRIVATE
	) : Attachment
	{
        // Acho que serve?
        $directory = substr(hash('sha256', class_basename($attachable)), 0, 16) . '/' . $attachable->id;

        $name = $file->hashName();

        $path = Storage::disk($disk->value)->putFileAs( $directory, $file, $name );

		$data['disk_type'] = $disk;
		$data['storage_type'] = StorageType::LOCAL;
		$data['file_mime'] = $file->getMimeType();
		$data['file_name'] = $file->getClientOriginalName();
		$data['file_path'] = $path;
		$data['user_id'] = $user->id;

		return $this->store->execute( $attachable, $data );
	}
}
