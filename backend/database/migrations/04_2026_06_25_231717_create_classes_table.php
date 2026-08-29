<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Enums\Shift;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->id();

            $table->foreignId('teacher_id')
                  ->constrained('users')
                  ->cascadeOnDelete();

            $table->enum( 'shift', Shift::cases() )->nullable();
            $table->string('name', 100);
            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
