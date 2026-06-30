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
        Schema::create('classes', function (Blueprint $table) 
        {
            $table->id();
            
            $table->foreignId('teacher_id')
                  ->constrained('teachers')
                  ->cascadeOnDelete();
            
            $table->string('name', 100);
            $table->boolean('active')->default(true);

            $table->timestamps();
        });

        /*
        Schema::create('turmas_aluno', function (Blueprint $table)
        {
            $table->foreignId('turma_id')
                  ->constrained('turmas')
                  ->cascadeOnDelete();

            $table->foreignId('aluno_id')
                  ->constrained('aluno')
                  ->cascadeOnDelete();

            $table->primary(['turma_id', 'aluno_id']);
        });
        */
    }

    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('turmas');
    }
};
