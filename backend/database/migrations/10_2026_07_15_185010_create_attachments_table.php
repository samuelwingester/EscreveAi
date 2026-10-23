<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\DiskType;
use App\Enums\StorageType;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->engine = 'InnoDB';

            $table->id();
            $table->timestamps();
            $table->string('file_name')->nullable();
            $table->string('file_mime')->nullable();
            $table->string('file_path');
            $table->enum('disk_type', DiskType::cases())->nullable();
            $table->enum('storage_type', StorageType::cases());

            $table->morphs('attachable');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
