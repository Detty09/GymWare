<?php

namespace App\Services;

use App\Models\WorkoutDetails;
use App\Repositories\WorkoutDetailRepository;
use App\Repositories\WorkoutPlanRepository;
use App\Repositories\WorkoutRepository;

class WorkoutService
{
    protected WorkoutRepository $workoutRepository;
    protected WorkoutDetailRepository $workoutDetailRepository;
    protected WorkoutPlanRepository $workoutPlanRepository;

    public function __construct(WorkoutRepository $workoutRepository, WorkoutDetailRepository $workoutDetailRepository, WorkoutPlanRepository $workoutPlanRepository)
    {
        $this->workoutRepository = $workoutRepository;
        $this->workoutDetailRepository = $workoutDetailRepository;
        $this->workoutPlanRepository = $workoutPlanRepository;
    }


    public function createWorkout(int $planId): int
    {
        return $this->workoutRepository->create($planId);
    }

    public function createWorkoutDetails(array $data): void
    {
        for ($j = 0; $j < count($data['exercise-id']); $j++) {
            $exerciseId = $data['exercise-id'][$j];
            $name = $data['names'][$j];
            $details = $this->getDetails($data, $exerciseId);

            for ($i = 0; $i < count($details['weight']); $i++) {
                $detail = [
                    'workout_id' => $data['workout_id'],
                    'exercise_id' => $exerciseId,
                    'name' => $name,
                    'set' => $i + 1,
                    'weight' => $details['weight'][$i],
                    'reps' => $details['reps'][$i],
                ];
                $this->workoutDetailRepository->create($detail);
            }
        }
    }

    private function getDetails(array $data, string $id): array
    {
        return [
            'weight' => $data['weight']["$id"],
            'reps' => $data['reps']["$id"],
        ];
    }

    public function getWorkoutWithDetailsByPlanId(int $planId): array
    {
        $data = $this->workoutRepository->findByPlanId($planId);

        if (empty($data)) {
            return [];
        }

        $formattedData = $this->getFormattedDetails($data);

        return [
            'name' => $data[0]['workout_plan']['name'],
            'workouts' => $formattedData,
        ];
    }

    private function getFormattedDetails(array $data): array
    {
        $detailsData = [];

        foreach ($data as $workoutData) {
            $detailsData += $this->formatDetail($workoutData);
        }

        return $detailsData;
    }

    private function formatDetail(mixed $workoutData): array
    {
        $details = [];
        $data = $workoutData['details'];

        for ($i = 0; $i < count($data); $i++) {
            $exercise = $data[$i]['name'];

            if (!array_key_exists($exercise, $details)) {
                $details[$exercise] = [
                    ['set' => $data[$i]['set'],
                        'reps' => $data[$i]['reps'],
                        'weight' => $data[$i]['weight'],]
                ];
            } else {
                $details[$exercise][] =
                    ['set' => $data[$i]['set'],
                        'reps' => $data[$i]['reps'],
                        'weight' => $data[$i]['weight'],];
            }
        }
        return [$workoutData['date'] => $details];
    }

    public function getWorkoutsWithDetailsByUserId(string $userId): array
    {
        $plans = $this->workoutPlanRepository->getByUserId($userId);
        $details = [];

        foreach ($plans as $plan) {
            $data = $this->workoutRepository->findByPlanId($plan['id']);

            if (empty($data)) {
                continue;
            }

            $name = $data[0]['workout_plan']['name'];
            $details[$name] = $this->getFormattedDetails($data);
        }
        return $details;
    }

    public function validateInputs(array ...$arrays): bool
    {
        foreach ($arrays as $array) {
            if (empty($array)) return false;

            foreach ($array as $inputs) {

                if (gettype($inputs) !== 'array') {
                    if ($inputs < 0 || empty($inputs)) return false;
                    continue;
                }

                foreach ($inputs as $input) {
                    if ($input < 0) return false;
                }
            }
        }
        return true;
    }
}
