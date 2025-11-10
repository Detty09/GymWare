<?php

namespace App\Services;

use App\Repositories\WorkoutDetailRepository;
use App\Repositories\WorkoutPlanRepository;
use App\Repositories\WorkoutRepository;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Carbon;

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


    public function createWorkout(int $planId, float $totalWeight): int
    {
        return $this->workoutRepository->create($planId, $totalWeight);
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
        $details = ['total_weight' => $workoutData['total_weight'], 'exercises' => []];
        $data = $workoutData['details'];

        for ($i = 0; $i < count($data); $i++) {
            $exercise = $data[$i]['name'];

            if (!array_key_exists($exercise, $details['exercises'])) {
                $details['exercises'][$exercise] = [
                    ['set' => $data[$i]['set'],
                        'reps' => $data[$i]['reps'],
                        'weight' => $data[$i]['weight'],]
                ];
            } else {
                $details['exercises'][$exercise][] =
                    ['set' => $data[$i]['set'],
                        'reps' => $data[$i]['reps'],
                        'weight' => $data[$i]['weight'],];
            }
        }

        $date = Carbon::parse($workoutData['date'])->format('d-m-Y H:i:s');

        return [$date => $details];
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

    public function getTotalWeight(array $exerciseId, array $weights, array $reps): float
    {
        $total = 0;

        foreach ($exerciseId as $exercise) {
            for ($i = 0; $i < count($weights[$exercise]); $i++) {
                $total += $weights[$exercise][$i] * $reps[$exercise][$i];
            }
        }

        return $total;
    }

    public function getWorkoutsDateAndWeightByPlanId(int $planId): array {
        return $this->workoutRepository->findByPlanIdDateAndWeight($planId);
    }

    public function createWorkoutFromRequest(Request $request): RedirectResponse|Redirector
    {
        $planId = $request->input('workout-plan-id');

        $exerciseIds = $request->input('exercise-id');
        $names = $request->input('exercise-name');
        $weight = $request->input('weight');
        $reps = $request->input('reps');

        $isValid = $this->validateInputs($names, $exerciseIds, $weight, $reps);

        if (!$isValid) {
            return redirect('/workout/create/' . $planId)->with('error', 'You cannot set a negative value to weight or repetition!');
        }

        $totalWeight = $this->getTotalWeight($exerciseIds, $weight, $reps);

        $workoutId = $this->createWorkout($planId, $totalWeight);
        $this->createWorkoutDetails([
            'workout_id' => $workoutId,
            'exercise-id' => $exerciseIds,
            'names' => $names,
            'weight' => $weight,
            'reps' => $reps
        ]);

        return redirect('/workout/history');
    }
}
