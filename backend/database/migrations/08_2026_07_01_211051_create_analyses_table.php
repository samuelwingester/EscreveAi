<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

use App\Models\Record;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('analyses', function (Blueprint $table)
        {
            $table->engine = 'InnoDB';

            $table->id();
            $table->timestamps();
            $table->text('observations');
            $table->json('spelling_errors');
            $table->json('mirrored_letters');
            $table->json('learning_difficulties');

            $table->foreignIdFor(Record::class)->constrained('records');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('analyses');
    }
};
