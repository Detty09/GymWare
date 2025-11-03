<?php

namespace App\Repositories;

use App\Models\Workout;

class WorkoutRepository
{

    public function create(string $planId): int
    {
        $workout = Workout::create(['workout_plan_id' => $planId]);
        return $workout->id;
    }

    public function findByPlanId(string $planId): array
    {
        return Workout::with('details', 'workoutPlan')->where('workout_plan_id', $planId)->get()->toArray();
    }
}
