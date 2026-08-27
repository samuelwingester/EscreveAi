<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\WritingLevel;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->id();

            /*
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->cascadeOnDelete();
            */

            // NT: Adicionar contatos depois

            $table->foreignId('class_id')
                  ->constrained('classes')
                  ->cascadeOnDelete();

            $table->string('name', 150);
            $table->enum('writing_level', WritingLevel::cases())->nullable();
            $table->text('observations')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

