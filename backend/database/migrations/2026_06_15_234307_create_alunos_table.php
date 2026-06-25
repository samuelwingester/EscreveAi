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
        Schema::create('alunos', function (Blueprint $table) 
        {
            $table->id('aluno_id');
            /*
            $table->foreignId('responsavel_id')->constrained(
                table:'responsaveis', indexName:'responsavel_id'
            );
            */
            $table->string("nome", 100);
            $table->date('data_nascimento');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alunos');
    }
};
