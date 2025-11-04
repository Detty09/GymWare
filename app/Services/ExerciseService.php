<?php

namespace App\Services;

use App\Models\Exercise;
use App\Repositories\ExerciseRepository;

class ExerciseService
{
    protected ExerciseRepository $repository;

    public function __construct(ExerciseRepository $repository)
    {
        $this->repository = $repository;
    }

    public function createExercise(array $data): int
    {
        return $this->repository->createExercise($data);
    }

    public function deleteExercise($exerciseId): void
    {
        $this->repository->delete($exerciseId);
    }


}
