<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Enums\Shift;
use App\Models\User;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('classes', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->id();
            $table->timestamps();
            $table->string('name', 100);
            $table->string('school', 100)->nullable();
            $table->enum('shift', Shift::cases())->nullable();
            $table->boolean('active')->default(true);

            $table->foreignIdFor(User::class, 'teacher_id')->constrained('users')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('classes');
    }
};
