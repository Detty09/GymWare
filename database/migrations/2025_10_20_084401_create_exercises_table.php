<?php

use App\Models\ExerciseDetail;
use App\Models\WorkoutPlan;
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
        Schema::create('exercises', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(WorkoutPlan::class)->constrained()->cascadeOnDelete();
            $table->string('api_exercise_id');
            $table->integer('sets');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('exercises');
    }
};
