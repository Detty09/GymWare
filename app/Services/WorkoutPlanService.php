<?php

namespace App\Services;

use App\Models\WorkoutPlan;
use App\Repositories\WorkoutPlanRepository;

class WorkoutPlanService
{
    protected WorkoutPlanRepository $repository;

    public function __construct(WorkoutPlanRepository $repository) {
        $this->repository = $repository;
    }

    public function createWorkoutPlan(array $data): WorkoutPlan
    {
        return $this->repository->create($data);
    }

    public function getWorkoutPlans(int $id): array
    {
        return $this->repository->getByUserId($id);
    }

    public function deleteWorkoutPlan(WorkoutPlan $plan): void
    {
        $this->repository->delete($plan);
    }

    public function getWorkoutPlanById(int $planId): array
    {
        return $this->repository->getByPlanId($planId);
    }

    public function updateWorkoutPlan(int $planId, array $newName): void
    {
        $this->repository->update($planId, $newName);
    }
}
