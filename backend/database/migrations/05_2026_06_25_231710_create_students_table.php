<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Enums\WritingLevel;
use App\Models\Classroom;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('students', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->id();
            $table->timestamps();
            $table->date('birth_date');
            $table->string('name', 150);
            $table->enum('writing_level', WritingLevel::cases())->nullable();
            $table->text('observations');

            $table->foreignIdFor(Classroom::class, 'classroom_id')->constrained('classes')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('students');
    }
};

