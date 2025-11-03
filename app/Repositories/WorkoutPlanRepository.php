<?php

namespace App\Repositories;

use App\Models\WorkoutPlan;

class WorkoutPlanRepository
{
    public function create(array $data): WorkoutPlan {
        return WorkoutPlan::create($data);
    }

    public function getByUserId(int $userId): array
    {
        return WorkoutPlan::where('user_id', $userId)->get()->toArray();
    }

    public function delete(WorkoutPlan $plan): void
    {
        $plan->deleteOrFail();
    }

    public function getByPlanId(int $planId): array
    {
        return WorkoutPlan::with('exercises')->where('id', $planId)->firstOrFail()->toArray();
    }


    public function update(int $planId, array $newName): void
    {
        $workoutPlan = WorkoutPlan::findOrFail($planId);
        $workoutPlan->update($newName);
    }

}
