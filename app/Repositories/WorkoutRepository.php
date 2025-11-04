<?php

namespace App\Repositories;

use App\Models\Workout;

class WorkoutRepository
{

    public function create(int $planId, float $totalWeight): int
    {
        $workout = Workout::create(['workout_plan_id' => $planId, 'total_weight' => $totalWeight]);
        return $workout->id;
    }

    public function findByPlanId(int $planId): array
    {
        return Workout::with('details', 'workoutPlan')->where('workout_plan_id', $planId)->get()->toArray();
    }

    public function findByPlanIdDateAndWeight($id): array
    {
        $collection = Workout::where('workout_plan_id', $id)->get();
        return $collection->pluck('total_weight', 'date')->toArray();
    }
}
