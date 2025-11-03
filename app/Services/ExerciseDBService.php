<?php

namespace App\Services;

use App\Repositories\ExerciseDBRepository;
use Illuminate\Support\Facades\Cache;

class ExerciseDBService {
    protected $exerciseRepository;

    public function __construct(ExerciseDBRepository $exerciseRepository) {
        $this->exerciseRepository = $exerciseRepository;
    }


    public function getByFilters($filters = [], $page = 1) {
        $bodypart = $filters['bodypart'] ?? "";
        $equipment = $filters['equipment'] ?? "";
        $cacheKey = "exercises_{$bodypart}_{$equipment}_page_{$page}";

        return Cache::remember($cacheKey, now()->addDay(), function () use ($filters, $page) {
            return $this->exerciseRepository->fetchByFilters($filters, $page);
        });

    }

    private function getById(string $id) {
        $cacheKey = "exercises_{$id}";
        return Cache::remember($cacheKey, now()->addDay(), function () use ($id) {
            return $this->exerciseRepository->fetchById($id);
        });
    }

    public function getExercisesForPlan(array $plan): array
    {
        $exercises = $plan['exercises'];

        $data = array_map(function ($exercise) {
            $exerciseApiData = $this->getById($exercise['api_exercise_id'])['data'];
            return ['id' => $exercise['id'],'sets' => $exercise['sets'] , 'data' => $exerciseApiData];
        }, $exercises);

        $plan['exercises'] = $data;
        return $plan;
    }
}
