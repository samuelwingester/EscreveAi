<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Student;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->id();
            $table->timestamps();
            $table->date('start_date');
            $table->date('end_date');

            $table->foreignIdFor(Student::class)->constrained('students')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};
