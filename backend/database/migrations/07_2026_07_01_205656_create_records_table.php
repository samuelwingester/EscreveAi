<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Student;
use App\Models\Activity;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('records', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->id();
            $table->timestamps();

            $table->foreignIdFor(Student::class)->constrained('students')->cascadeOnDelete();
            $table->foreignIdFor(Activity::class)->constrained('activities')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('records');
    }
};
