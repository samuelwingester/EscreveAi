<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Classroom;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('activities', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->id();
            $table->timestamps();
            $table->string('title', 100);
            $table->text('description');

            $table->foreignIdFor(Classroom::class, 'classroom_id')->constrained('classes')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('activities');
    }
};
