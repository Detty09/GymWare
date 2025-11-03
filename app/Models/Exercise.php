<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Exercise extends Model
{
    protected $fillable = [
        'workout_plan_id',
        'api_exercise_id',
        'sets'
    ];

    public $timestamps = false;

    public function workoutPlan(): BelongsTo
    {
        return $this->belongsTo(WorkoutPlan::class);
    }

    public function exerciseDetails(): HasMany {
        return $this->hasMany(ExerciseDetail::class);
    }
}
