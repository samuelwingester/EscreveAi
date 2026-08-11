<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\DiskType;
use App\Enums\StorageType;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('attachments', function (Blueprint $table) {
            $table->id();

            $table->morphs('attachable');

            $table->string('file_name')->nullable();
            $table->string('file_mime')->nullable();
            $table->string('file_path');

            $table->enum('disk_type', DiskType::cases())->nullable();
            $table->enum('storage_type', StorageType::cases());

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attachments');
    }
};
