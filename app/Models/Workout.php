<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Workout extends Model
{
    protected $fillable = ['workout_plan_id', 'date'];
    public $timestamps = false;

    public function workoutPlan(): BelongsTo {
        return $this->belongsTo(WorkoutPlan::class);
    }

    public function details(): HasMany {
        return $this->hasMany(WorkoutDetails::class);
    }
}
