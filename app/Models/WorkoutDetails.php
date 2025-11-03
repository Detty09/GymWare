<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WorkoutDetails extends Model
{
    public $timestamps = false;
    protected $fillable = [
        'workout_id',
        'exercise_id',
        'name',
        'set',
        'weight',
        'reps',
    ];

    public function exercise(): BelongsTo {
        return $this->belongsTo(Exercise::class);
    }

    public function workout(): BelongsTo {
        return $this->belongsTo(Workout::class);
    }
}
