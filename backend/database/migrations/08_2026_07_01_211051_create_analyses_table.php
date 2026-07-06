<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('analyses', function (Blueprint $table) 
        {
            $table->engine = 'InnoDB';

            $table->id();

            $table->foreignId('record_id')
                  ->constrained('records')
                  ->cascadeOnDelete();

            $table->text('observations');
            $table->json('spelling_errors');
            $table->json('mirrored_letters');
            $table->json('learning_difficulties');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};
