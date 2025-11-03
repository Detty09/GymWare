<?php

namespace App\Repositories;

use App\Models\Workout;
use App\Models\WorkoutDetails;

class WorkoutDetailRepository
{

    public function create(array $data): void
    {
        WorkoutDetails::create($data);
    }
}
