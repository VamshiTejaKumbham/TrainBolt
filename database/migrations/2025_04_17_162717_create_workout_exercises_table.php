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
        Schema::create('workout_exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignId('workout_id')->constrained()->onDelete('cascade');
            $table->foreignId('exercise_id')->nullable()->constrained()->onDelete('set null');
            $table->string('custom_exercise_name')->nullable();
            $table->integer('sets')->nullable();
            $table->integer('reps')->nullable();
            $table->float('weight')->nullable();
            $table->integer('duration')->nullable()->comment('Duration in seconds, for timed exercises');
            $table->text('notes')->nullable();
            $table->timestamps();

            // Composite unique index to prevent duplicate exercise entries within the same workout
            $table->unique(['workout_id', 'exercise_id', 'custom_exercise_name'], 'wkout_ex_unique');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('workout_exercises');
    }
};