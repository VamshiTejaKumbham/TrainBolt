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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // Foreign key linking to the users table
            $table->string('food_description');
            $table->integer('calories');
            $table->float('protein', 8, 2)->nullable(); // Protein in grams
            $table->float('carbs', 8, 2)->nullable();   // Carbohydrates in grams
            $table->float('fats', 8, 2)->nullable();    // Fats in grams
            $table->timestamp('meal_time')->nullable(); // Time the meal was consumed
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }
};