<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;
use Tests\TestCase;

use Illuminate\Support\Facades\Log;

use App\Services\Attachment\StoreFileAttachmentService;
use App\Services\Attachment\StoreUrlAttachmentService;
use App\Services\Attachment\DeleteAttachmentService;

use App\Models\Attachment;
use App\Models\Activity;

use App\Enums\DiskType;
use App\Enums\StorageType;

class AttachmentServicesTest extends TestCase
{
    use RefreshDatabase;
   
    public function test_store_file_attachment_service_success( $service = new StoreFileAttachmentService() ): void
    {
        $disk = Storage::fake( DiskType::TESTING );

        $attachable = Activity::factory()->withClassroom()->create();

        $file = UploadedFile::fake()->create( 'test.txt', 200 );

        $attachment = $service->execute( $attachable, $file, DiskType::TESTING );

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------    
        $this->assertDatabaseCount('attachments', 1);

        $disk->assertExists( $attachment->file_path );

        $this->assertEquals( StorageType::LOCAL, $attachment->storage_type );
        //--------------------------------------------------------
    }

    public function test_store_url_attachment_service_success( $service = new StoreUrlAttachmentService() ): void
    {
        $attachable = Activity::factory()->withClassroom()->create();

        $attachment = $service->execute( $attachable, 'https://google.com' );

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $this->assertDatabaseCount('attachments', 1);

        $this->assertEquals( 'https://google.com', $attachment->file_path );

        $this->assertEquals( StorageType::URL, $attachment->storage_type ); 
        //--------------------------------------------------------       
    }

    public function test_delete_attachment_service_success( $service = new DeleteAttachmentService() ): void
    {
        $disk = Storage::fake( DiskType::TESTING );

        $attachment = Attachment::factory()->forActivity()->create();

        $file = UploadedFile::fake()->create( $attachment->file_name, 200 );

        $path = $disk->putFile( 'test', $file );

        $attachment->file_path = $path; 

        $attachment->save();

        //--------------------------------------------------------
        // Asserts
        //--------------------------------------------------------
        $this->assertEquals( $path, $attachment->file_path );

        $this->assertTrue( $service->execute( $attachment ) );

        $disk->assertMissing( $path );
        //--------------------------------------------------------
    }
}
