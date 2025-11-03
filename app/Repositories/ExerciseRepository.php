<?php

namespace App\Repositories;

use App\Models\Exercise;

class ExerciseRepository
{

    public function createExercise(array $data): int
    {
        $exercise = Exercise::create($data);
        return $exercise->id;
    }

    public function delete($exerciseId): void
    {
        Exercise::destroy($exerciseId);
    }
}
